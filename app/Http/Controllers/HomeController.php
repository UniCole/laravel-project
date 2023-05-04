<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


class HomeController extends Controller
{
    public function index(){
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function loadStore($id){
        $user = User::findOrFail($id);

        $categories = $user->categories;
        $products = $user->products;

        return $user;
    }

    // public function client(){
    //     dd('client');
    // }

    // public function admin(){
    //     dd('admin');
    // }
    
    public function products(){
        dd('products');
    }

    public function dashboard(){
        $data = [];
        if(Auth::user()->role === 'admin'){
            $data['stores'] = User::where('role', 'client')->paginate();   
        }

        return Inertia::render('Dashboard', $data);
    }
}
