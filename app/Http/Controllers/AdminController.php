<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Display a list of all users and their stores
        $users = User::with('store')->get();
        return view('admin.index', compact('users'));
    }

    public function create()
    {
        // Show the form for creating a new user and store
        return view('admin.create');
    }

    public function store(Request $request)
    {
        // Create a new user and store
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $store = new Store;
        $store->name = $request->input('store_name');
        $store->user_id = $user->id;
        $store->save();

        return redirect()->route('admin.index');
    }

    public function edit(User $user)
    {
        // Show the form for editing a user and their store
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Update a user and their store
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        $store = $user->store;
        $store->name = $request->input('store_name');
        $store->save();

        return redirect()->route('admin.index');
    }

    public function destroy(User $user)
    {
        // Delete a user and their store
        $user->delete();

        return redirect()->route('admin.index');
    }

    public function deactivate(Store $store)
    {
        // Deactivate a store and delete all data
        $store->is_active = false;
        $store->products()->delete();
        $store->delete();

        return redirect()->route('admin.index');
    }

    public function addAdmin(User $user)
    {
        // Add a new admin
        $admin = new User;
        $admin->name = 'New Admin';
        $admin->email = 'newadmin@example.com';
        $admin->password = bcrypt('password');
        $admin->is_admin = true;
        $admin->save();

        $user->admins()->attach($admin->id);

        return redirect()->route('admin.index');
    }

    public function products(User $user)
    {
        // Show the products for a specific user
        $products = $user->products;
        return view('admin.products', compact('user', 'products'));
    }

    public function createProduct(User $user)
    {
        // Show the form for creating a new product
        $categories = Category::all();
        return view('admin.create-product', compact('user', 'categories'));
    }

    public function storeProduct(Request $request, User $user)
    {
        // Create a new product for a specific user
        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->user_id = $user->id;
        $product->save();
        return redirect()->route('admin.products', $user);
    }
    
    public function editProduct(User $user, Product $product)
    {
        // Show the form for editing a product
        $categories = Category::all();
        return view('admin.edit-product', compact('user', 'product', 'categories'));
    }
    
    public function updateProduct(Request $request, User $user, Product $product)
    {
        // Update a product
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->save();
    
        return redirect()->route('admin.products', $user);
    }
    
    public function destroyProduct(User $user, Product $product)
    {
        // Delete a product
        $product->delete();
    
        return redirect()->route('admin.products', $user);
    }
}

?>

