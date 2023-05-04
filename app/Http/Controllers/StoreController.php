<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class StoreController extends Controller
{
    public function index($id, Request $request)
    {
        $shop = User::where('role', 'client')->where('id', $id)->first();
        if(!$shop){
            abort(404);
        }
        $products = Product::where('user_id', $id)
        ->when($request->has('category') && $request->category > 0, function($query) use($request){
            return $query->where('category_id', $request->category);
        })
        ->paginate();
        $categories = $shop->categories;
        $selectedCategory = $request->category ?? 0;

        return Inertia::render('Store/Index', [
            'categories' => $categories,
            'products' => $products,
            'selected_category' => $selectedCategory,
            'title' => $selectedCategory > 0 ? 
            "shopping by category - " . $products->first()->category->name : 'Welcome to our store',
            'store_name' => $shop->name,
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return to_route('dashboard')->with('message', 'User has been deleted');
    }

    public function impersonateUser($id)
    {
        session(['impersonator' => Auth::id()]);
        Auth::loginUsingId($id);
        return to_route('dashboard');
    }

    public function stopImpersonatingUser()
    {
        $originalUserId = session('impersonator');
        Auth::loginUsingId($originalUserId);
        session()->forget('impersonator');
        
        return redirect()->route('dashboard');
    }



}
