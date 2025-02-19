<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        $product = Product::all();
        $item = Item::all();

        $productsByCategory = $product->groupBy('category_id')->map(function ($items) {
            return $items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                ];
            });
        });

        $itemsByProduct = $item->groupBy('product_id')->map(function ($items) {
            return $items->map(function ($item) {
                return [
                    'item_id' => $item->id,
                    'item_name' => $item->item_name,
                ];
            });
        });

        return view('UsersPage.layouts.app', compact('categories', 'productsByCategory', 'itemsByProduct'));
    }


    public function findParts(Request $request)
    {
        $item = Item::where('category_id', $request->category_id)
                     ->where('product_id', $request->product_id)
                     ->where('item_id', $request->id)
                     ->get();

        return response()->json($item);
    }
}
