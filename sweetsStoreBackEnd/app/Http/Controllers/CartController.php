<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
                $user_ip = $request->ip();
    
                $cartItem = Cart::where('product_id', $product_id)
                    ->where('user_ip', $user_ip)
                    ->where('weight', $weight)
                    ->first();
    
                if ($cartItem) {
                    $cartItem->quantity += $quantity;
                    $cartItem->save();
                } else {
                    Cart::create([
                        'user_ip' => $user_ip,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'weight' => $weight,
                        'created_at' => Carbon::now(),
                    ]);
                }
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

    public function CartUsersSide(Request $request) {
        $user_id = $request->input('user_id');
        $user_ip = $request->input('user_ip');
        
        if ($user_id) {
            $cart = Cart::with('product')
                ->where('user_id', $user_id)
                ->get();
        } else if ($user_ip) {
            $cart = Cart::with('product')
                ->where('user_ip', $user_ip)
                ->get();
        } else {
            return response()->json(['cart' => []]);
        }
        
        return response()->json(['cart' => $cart]);
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
        $user_id = $request->input('user_id');
        $user_ip = $request->input('user_ip');
    
        $query = Cart::query();
    
        if ($user_id) {
            $query->where('user_id', $user_id);
        } elseif ($user_ip) {
            $query->where('user_ip', $user_ip);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'يجب توفير user_id أو user_ip',
            ], 400);
        }
    
        $cartItems = $query->get();
    
        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'لا توجد عناصر في السلة.',
            ], 404);
        }
    
        $query->delete();
    
        return response()->json([
            'status' => 200,
            'message' => 'تم مسح السلة بنجاح',
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

    public function addToCart(Request $request, $item_id)
    {
        return response()->json([
            'success' => false,
            'message' => 'This endpoint is deprecated. Use addToCartUsersSide instead.',
        ], 410);
    }

    public function updateCart(Request $request, $cartId)
    {
        return response()->json([
            'success' => false,
            'message' => 'This endpoint is deprecated.',
        ], 410);
    }

    public function removeFromCart($cartId)
    {
        return redirect()->route('cart.view');
    }

    public function viewCart()
    {
        return view('UsersPage.Cart', ['cartItems' => []]);
    }

    public function statistics()
    {
        $totalCart = Cart::count();
        return view('dashboard', compact('totalCart'));
    }

    public function clearCart()
    {
        if (auth('sanctum')->check()) {
            Cart::where('user_id', auth('sanctum')->id())->delete();
        }
        return response()->json(['success' => true]);
    }

    public function getCartItems($userId)
    {
        $cartItems = Cart::where('user_id', $userId)->get();
        return response()->json($cartItems);
    }
}