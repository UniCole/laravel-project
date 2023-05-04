<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;



class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('user_id', Auth::user()->id)
        ->when($request->has('category'), function($query) use($request) {
            return $query->where('category_id', $request->get('category'));
        })->orderBy('created_at', 'desc')
            ->get();
        $categories = Category::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render('Product/Index', [
            'products' => $products,
            'categories' => $categories,
            'selected_category' => $request->category ?? 0,
        ]);
    }


    public function create()
    {
        $categories = Category::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render('Product/Create', [
            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => [
                'required',
                'min:2',
                'max:50',
                'unique:products,name,' . $user->id . ',id,user_id,' . $user->id
            ],
            'image' => 'required|url|',
            'price' => 'required|decimal:0,2|min:1|max:9999',
            'quantity' => 'required|numeric|min:0|max:9999',
            'category' => 'required|exists:categories,id,user_id,' . $user->id
        ]);

        Product::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'category_id' => $request->category,
            'image' => $request->image,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);
        return to_route('products.index')->with('message', 'Product has been updated');

    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return Inertia::render('Product/Edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'min:2',
                'max:50',
                'unique:products,name,' . $id
            ],
            'image' => 'required|url|',
            'price' => 'required|decimal:2|min:1|max:9999',
            'quantity' => 'required|numeric|min:0|max:9999',

        ]);


        $Product = Product::findOrFail($id);
        $Product->update([
            'name' => $request->name,
            'image' => $request->image,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return to_route('products.index')->with('message', 'Product has been updated');
    }

    public function destroy($id)
    {
        Product::where('user_id', Auth::user()->id)->whereId($id)->delete();
        return to_route('products.index')->with('message', 'Product has been removed');
    }
}
