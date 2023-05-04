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

    public function dashboard(){
        $data = [];
        if(Auth::user()->role === 'admin'){
            $data['stores'] = User::where('role', 'client')->paginate();   
        }

        return Inertia::render('Dashboard', $data);
    }
}
