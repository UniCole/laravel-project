<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use Inertia\Inertia;


class StoreController extends Controller
{
    public function index($id, Request $request)
    {
        $shop = User::where('role', 'client')->where('id', $id)->first();
        $products = Product::where('user_id', $id)
        ->when($request->has('category') && $request->category > 0, function($query) use($request){
            return $query->where('category_id', $request->category);
        })
        ->paginate();
        $categories = $shop->categories;

        return Inertia::render('Store/Index', [
            'categories' => $categories,
            'products' => $products,
            'selected_category' => $request->category ?? 0,
        ]);
    }
}
