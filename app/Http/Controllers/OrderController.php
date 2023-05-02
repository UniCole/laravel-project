<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders;
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        $order = new Order();
        $order->user_id = $user->id;
        $order->total = 0;
        $order->save();

        $total = 0;

        foreach ($validatedData['products'] as $productData) {
            $product = Product::findOrFail($productData['id']);
            $quantity = $productData['quantity'];
            $total += $product->price * $quantity;
            $order->products()->attach($product->id, [
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }

        $order->total = $total;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}

?>