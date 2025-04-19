<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Item;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('UsersPage.UserPage.orders', compact('orders'));
    }

    public function createOrder(Request $request)
    {
        $user = Auth::user();

        $total = DB::table('items')
            ->join('carts', 'items.id', '=', 'carts.item_id')
            ->where('carts.user_id', $user->id)
            ->sum('items.item_price');

        $cartItems = Cart::where('user_id', $user->id)
            ->with('item')
            ->get();

        try {
            DB::transaction(function () use ($cartItems, $total, $user) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'total' => $total,
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($cartItems as $cartItem) {
                    if (!$cartItem->item) {
                        throw new \Exception("Item not found for cart item: " . $cartItem->id);
                    }

                    OrderItem::create([
                        'order_id' => $order->id,
                        'item_id' => $cartItem->item_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->item->item_price,
                    ]);

                    $cartItem->item->quantity -= $cartItem->quantity;
                    $cartItem->item->save();
                }

                Cart::where('user_id', $user->id)->delete();
            });

            return redirect('cart')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Thank you for shopping with us',
                    'text' => 'Your order is being prepared.',
                ]);
        } catch (\Exception $e) {
            Log::error('Error placing order: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect('cart')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'An error occurred',
                    'text' => 'There was an error while placing your order. Please try again later.',
                ]);
        }
    }

    public function showOrderDetails($orderId)
    {
        $order = Order::findOrFail($orderId);
        $items = $order->orderItems;
        return view('UsersPage.UserPage.detailOrders', compact('order', 'items'));
    }

    public function order(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|integer',
            'user_ip' => 'nullable|string',
            'total_product' => 'required|integer',
            'total_price' => 'required|numeric',
            'checkout_num' => 'required|string',
        ]);

        $order = Order::create([
            'user_id' => $request->input('user_id'),
            'user_ip' => $request->input('user_ip'),
            'total_product' => $request->input('total_product'),
            'total_price' => $request->input('total_price'),
            'checkout_num' => $request->input('checkout_num'),
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'تم تأكيد الطلب بنجاح!',
            'order' => $order,
        ]);
    }

    public function usersOrderItem(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|integer',
            'user_ip' => 'nullable|string',
            'checkout_num' => 'required|string',
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'weight' => 'nullable|numeric',
        ]);

        $orderItem = OrderItem::create([
            'user_id' => $request->input('user_id'),
            'user_ip' => $request->input('user_ip'),
            'checkout_num' => $request->input('checkout_num'),
            'order_id' => $request->input('order_id'),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'weight' => $request->input('weight'),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'تم حفظ المنتج في الطلب بنجاح!',
            'order_item' => $orderItem,
        ]);
    }

    public function transferCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        $user_ip = $request->ip();
        Cart::where('user_ip', $user_ip)->update([
            'user_id' => $request->input('user_id'),
            'user_ip' => null,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'تم نقل عناصر السلة بنجاح!',
        ]);
    }

    public function getUserIp(Request $request)
    {
        return response()->json([
            'status' => 200,
            'user_ip' => $request->ip(),
        ]);
    }

    public function getUserOrders(Request $request)
    {
        $userId = $request->query('user_id');
        $orders = Order::where('user_id', $userId)->get();

        return response()->json([
            'orders' => $orders,
        ]);
    }
}