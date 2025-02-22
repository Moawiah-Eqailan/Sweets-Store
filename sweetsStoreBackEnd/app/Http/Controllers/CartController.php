<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        if (auth()->check()) {
            $cartItem = Cart::where('item_id', $item_id)->where('user_id', auth()->id())->first();

            if ($cartItem) {
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => auth()->id(),
                    'item_id' => $item_id,
                    'quantity' => 1,
                    'created_at' => Carbon::now(),
                ]);
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$item_id])) {
                $cart[$item_id]['quantity']++;
            } else {
                $cart[$item_id] = [
                    'item_id' => $item_id,
                    'quantity' => 1,
                ];
            }

            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to the cart.',
        ]);
    }

    public function updateCart(Request $request, $cartId)
    {
        if (auth()->check()) {
            $cartItem = Cart::findOrFail($cartId);
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            $total = Cart::with('item')->where('user_id', auth()->id())->get()->sum(function ($item) {
                return $item->item->item_price * $item->quantity;
            });

            return response()->json(['success' => true, 'total' => $total]);
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$cartId])) {
                $cart[$cartId]['quantity'] = $request->quantity;
                session()->put('cart', $cart);

                $total = array_reduce($cart, function ($carry, $item) {
                    return $carry + ($item['price'] * $item['quantity']);
                }, 0);

                return response()->json(['success' => true, 'total' => $total]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Item not found']);
    }


    public function removeFromCart($cartId)
    {
        if (auth()->check()) {
            $cartItem = Cart::findOrFail($cartId);
            $cartItem->delete();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$cartId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.view');
    }

    public function viewCart()
    {
        if (auth()->check()) {
            $cartItems = Cart::where('user_id', auth()->id())->get();
        } else {
            $cartItems = session()->get('cart', []);
        }

        return view('UsersPage.Cart', compact('cartItems'));
    }

    public function statistics()
    {
        $totalCart = Cart::count();
        return view('dashboard', compact('totalCart'));
    }

    public function clearCart()
    {
        Cart::where('user_id', auth()->id())->delete();
        return response()->json(['success' => true]);
    }
    public function getCartItems($userId)
    {
        $cartItems = Cart::where('user_id', $userId)->get();
        return response()->json($cartItems);
    }


    public function addToCartUsersSide(Request $request)
    {
        try {
            $product_id = $request->input('product_id');
            $quantity = $request->input('quantity', 1);
            $weight = $request->input('weight', null);

            $product = Product::find($product_id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.',
                ], 404);
            }

            if (auth('sanctum')->check()) {
                $user_id = auth('sanctum')->id();

                $cartItem = Cart::where('product_id', $product_id)
                    ->where('user_id', $user_id)
                    ->where('weight', $weight)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += $quantity;
                    $cartItem->save();
                } else {
                    Cart::create([
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'weight' => $weight,
                        'created_at' => Carbon::now(),
                    ]);
                }
            } else {
                $cart = session()->get('cart', []);

                $cartKey = $product_id . '-' . $weight;

                if (isset($cart[$cartKey])) {
                    $cart[$cartKey]['quantity'] += $quantity;
                } else {
                    $cart[$cartKey] = [
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'weight' => $weight,
                    ];
                }

                session()->put('cart', $cart);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product to the cart.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }





    public function CartUsersSide(Request $request)
    {
        $user_id = $request->input('user_id');

        if (!$user_id) {
            return response()->json([
                'status' => 400,
                'message' => 'User ID is required.',
            ], 400);
        }

        $cart = Cart::where('user_id', $user_id)
            ->with('product:product_id,product_name,product_image,product_price,offers')
            ->get();

        $cart->transform(function ($item) {
            if ($item->product) {
                $item->product->product_image = asset('storage/' . $item->product->product_image);
            }
            return $item;
        });

        return response()->json([
            'status' => 200,
            'cart' => $cart,
        ]);
    }

    public function removeCartItem($cartId)
    {
        $cartItem = Cart::find($cartId);

        if (!$cartItem) {
            return response()->json([
                'status' => 404,
                'message' => 'العنصر غير موجود في السلة.',
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'status' => 200,
            'message' => 'تم حذف العنصر من السلة بنجاح!',
        ]);
    }
    public function clearCartUsersSide(Request $request)
    {
        $userId = $request->input('user_id');

        if (!$userId) {
            return response()->json([
                'status' => 400,
                'message' => 'يجب تقديم معرف المستخدم (user_id).',
            ], 400);
        }

        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'لا توجد عناصر في السلة.',
            ], 404);
        }

        foreach ($cartItems as $cartItem) {
            $cartItem->delete();
        }

        return response()->json([
            'status' => 200,
            'message' => 'تم مسح جميع العناصر من السلة بنجاح!',
        ]);
    }
    public function topProducts(Request $request)
    {
        $cart = Cart::with('product:product_id,product_name,product_image,product_price,offers')
            ->get();
    
        $productCount = [];
    
        foreach ($cart as $item) {
            if ($item->product) {
                $productId = $item->product->product_id;
    
                if (isset($productCount[$productId])) {
                    $productCount[$productId]['count'] += 1;
                } else {
                    $productCount[$productId] = [
                        'product' => $item->product,
                        'count' => 1,
                    ];
                }
            }
        }
    
        $sortedProducts = collect($productCount)
            ->sortByDesc(function ($product) {
                return $product['count'];
            })
            ->take(3)
            ->values();
    
        $topProducts = $sortedProducts->map(function ($product) {
            $product['product']->product_image = asset('storage/' . $product['product']->product_image);
            return $product['product'];
        });
    
        return response()->json([
            'status' => 200,
            'top_products' => $topProducts,
        ]);
    }
    
}
