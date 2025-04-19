<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDelivery;
use App\Models\Cart;

class OrderDeliveryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|integer',
            'user_ip' => 'nullable|string',
            'checkout_num' => 'required|string',
            'total_price' => 'required|numeric',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
        ]);

        $user_ip = $request->input('user_ip') ?? $request->ip();

        $delivery = OrderDelivery::create([
            'user_id' => $request->input('user_id'),
            'user_ip' => $user_ip,
            'checkout_num' => $request->input('checkout_num'),
            'total_price' => $request->input('total_price'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
        ]);

        if ($request->input('user_id')) {
            Cart::where('user_ip', $user_ip)->update([
                'user_id' => $request->input('user_id'),
                'user_ip' => null,
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'تم حفظ معلومات التسليم بنجاح!',
            'delivery' => $delivery,
        ]);
    }
}