<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDelivery;

class OrderDeliveryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'checkout_num' => 'required|string',
            'total_price' => 'required|numeric',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
        ]);

        $delivery = OrderDelivery::create([
            'checkout_num' => $request->input('checkout_num'),
            'total_price' => $request->input('total_price'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'تم حفظ معلومات التسليم بنجاح!',
            'delivery' => $delivery,
        ]);
    }
}