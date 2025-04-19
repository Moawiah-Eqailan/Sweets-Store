<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function register()
    {
        return view('auth/register');
    }


    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'state' => $request->state,
            'password' => Hash::make($request->password),
            'level' => 'Admin'
        ]);

        return redirect()->route('login');
    }
    public function login()
    {
        return view('auth/login');
    }

    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'You are not authorized to log on as an administrator.');
        }

        return redirect()->route('dashboard');
    }



    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function profile()
    {
        return view('profile');
    }

    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        // $totalPurchases = Cart::count();
        $totalCart = Cart::count();
        $totalMessage = ContactUs::count();
        $totalStatus = Order::where('status', 'pending')->count();
        $totalQuantity = Order::sum('total_product');
        $totalPrice = DB::table('orders')
            ->sum(DB::raw('total_price * total_product'));

        return view('dashboard', compact('totalUsers', 'totalProducts',  'totalCart', 'totalPrice', 'totalMessage', 'totalQuantity', 'totalStatus'));
    }


    public function filter(Request $request)
    {
        $categoryId = $request->query('category');
        $productId = $request->query('product');
        $id = $request->query('id');

        $filteredParts = Item::where('category_id', $categoryId)
            ->where('product_id', $productId)
            ->where('id', $id)
            ->get();

        return view('UsersPage.filter', compact('filteredParts'));
    }



    public function loginUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 401,
                'message' => 'بيانات الاعتماد غير صحيحة.',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'تم تسجيل الدخول بنجاح!',
            'user' => $user,
            'token' => $token,
        ]);
    }





    public function registerUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $userIp = $request->ip();
        $user = User::where('user_ip', $userIp)->first();

        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'user_ip' => null, 
            ]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'level' => 'User',

            ]);
        }
        Cart::where('user_ip', $userIp)->update([
            'user_id' => $user->id,
            'user_ip' => null,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
