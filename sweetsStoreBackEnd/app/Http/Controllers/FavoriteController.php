<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class FavoriteController extends Controller
{
    public function toggle($id)
    {
        $user = auth()->user();

        if (!$user) {
            $favorites = Session::get('favorites', []);

            if (in_array($id, $favorites)) {
                $favorites = array_diff($favorites, [$id]);
            } else {
                $favorites[] = $id;
            }

            Session::put('UsersPage.favorites', $favorites);

            return response()->json(['success' => true, 'isFavorite' => in_array($id, $favorites)]);
        }

        $isFavorite = $user->favorites()->where('item_id', $id)->exists();

        if ($isFavorite) {
            $user->favorites()->detach($id);
        } else {
            $user->favorites()->attach($id);
        }

        return response()->json(['success' => true, 'isFavorite' => !$isFavorite]);
    }

    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            $favorites = session()->get('favorites', []);
            $favoriteItems = Item::whereIn('id', $favorites)->get();
            foreach ($favoriteItems as $favorite) {
                $favorite->isFavorite = in_array($favorite->id, $favorites);
            }
        } else {
            $favoriteItems = $user->favorites;
            foreach ($favoriteItems as $favorite) {
                $favorite->isFavorite = true;
            }
        }

        return view('UsersPage.Favorites', compact('favoriteItems'));
    }

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
        } 

        return response()->json([
            'success' => true,
            'message' => 'Item added to the cart.',
        ]);
    }
    
}
