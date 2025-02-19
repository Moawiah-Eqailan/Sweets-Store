<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Item;
use App\Models\Cart;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the items.
     */
    public function index()
    {
        $items = Item::orderBy('created_at', 'DESC')->paginate(10);
        $items = DB::table('items')
            ->orderBy('items.id', 'desc')
            ->paginate(5);
        return view('Admin.Items.index', compact('items'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        $product = Product::pluck('product_name', 'product_id');
        $category = Category::pluck('category_name', 'category_id');

        return view('Admin.Items.create', compact('product', 'category'));
    }


    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'item_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // رفع الصورة
        if ($request->hasFile('item_image')) {
            $imagePath = $request->file('item_image')->store('Items/images', 'public');
            $validatedData['item_image'] = $imagePath;
        }

        // حفظ العنصر
        Item::create($validatedData);

        return redirect()->route('Items')->with('success', 'تمت إضافة الفرع بنجاح.');
    }





    /**
     * Display the specified item.
     */
    public function show(string $id)
    {
        $item = Item::findOrFail($id);

        $categories = Category::pluck('category_name', 'category_id');

        $product = Product::pluck('product_name', 'product_id');
        return view('Admin.Items.show', compact('item', 'product', 'categories'));
    }


    /**
     * Show the form for editing the specified item.
     */
    // public function edit(string $id)
    // {

    //     $item = Item::findOrFail($id);
    //     return view('Items.edit', compact('item'));
    // }





    public function edit(string $id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::pluck('category_name', 'category_id');
        $product = Product::pluck('product_name', 'product_id');

        return view('Admin.Items.edit', compact('item', 'product', 'categories'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Item::findOrFail($id);

        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'item_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('item_image')) {
            if ($item->item_image && Storage::exists('public/' . $item->item_image)) {
                Storage::delete('public/' . $item->item_image);
            }
            $validatedData['item_image'] = $request->file('item_image')->store('Items/images', 'public');
        } else {
            $validatedData['item_image'] = $item->item_image;
        }

        $item->update($validatedData);

        return redirect()->route('Items')->with('success', 'تم التحديث بنجاح.');
    }



    /**
     * Remove the specified item from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);


        $item->delete();

        return redirect()->route('Items')->with('success', 'Item deleted successfully.');
    }

    /**
     * Search for items by name or description.
     */
    public function searrchh(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $items = Item::where('item_name', 'LIKE', "%$query%")
                ->orWhere('item_description', 'LIKE', "%$query%")
                ->get();
        } else {
            $items = Item::orderBy('created_at', 'DESC')->paginate(10);
        }

        return view('Admin.Items.index', ['items' => $items]);
    }

    /**
     * Return all items for the app layout.
     */

    public function view()
    {
        $items = Item::all();
        return view('UsersPage.item', compact('items'));
    }


    public function showItem($product_id)
    {
        $items = Item::where('product_id', $product_id)->get();
        return view('UsersPage.Item', compact('items'));
    }


    // public function detail($id)
    // {
    //     $item = Item::findOrFail($id);

    //     $user = auth()->user();

    //     if (!$user) {
    //         $favorites = session()->get('favorites', []);
    //         $isFavorite = in_array($item->id, $favorites);
    //     } else {
    //         $isFavorite = $user->favorites()->where('item_id', $item->id)->exists();
    //     }

    //     return view('UsersPage.detail', compact('item', 'isFavorite'));
    // }



    // public function Item($id)
    // {
    //     $items = Item::where('product_id', $id)->get();
    //     $user = auth()->user();

    //     foreach ($items as $item) {
    //         if (!$user) {
    //             $favorites = session()->get('favorites', []);
    //             $item->isFavorite = in_array($item->id, $favorites);
    //         } else {
    //             $item->isFavorite = $user->favorites()->where('item_id', $item->id)->exists();
    //         }
    //     }

    //     return view('UsersPage.Item', compact('items'));
    // }



    public function getItemsByProduct($productId)
    {
        $items = Item::where('product_id', $productId)->get();
        return response()->json($items);
    }

    public function statistics()
    {
        $totalPrice = Item::sum('item_price');
        return view('dashboard', compact('totalPrice'));
    }



    public function addToCart($item_id)
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

    public function showItemDetail($id)
    {
        $item = Item::find($id);

        if (!$item) {
            abort(404, 'Item not found');
        }

        $isFavorite = Auth::check() && $item->favorites()->where('user_id', Auth::id())->exists();

        $relatedItems = Item::where('product_id', $item->product_id)
            ->where('id', '!=', $item->id)
            ->limit(6)
            ->get();

        return view('UsersPage.detail', [
            'item' => $item,
            'relatedItems' => $relatedItems,
            'isFavorite' => $isFavorite,
        ]);
    }


    public function sideBar()
    {
        $item = Item::all();


        return response()->json([
            'status' => 200,
            'item' => $item
        ]);
    }


    public function ItemProduct()
    {
        $item = Item::all();


        $item->transform(function ($item) {
            $item->item_image = asset('public/' . $item->item_image);
            return $item;
        });
        return response()->json([
            'status' => 200,
            'item' => $item
        ]);
    }
    public function Filter(Request $request)
    {
        $item = Item::all();

        $query = Category::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }


        return response()->json([
            'status' => 200,
            'item' => $item
        ]);
    }
   
    
    
}
