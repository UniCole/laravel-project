<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Category/Index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return Inertia::render('Category/Create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => [ 
            'required',
            'min:2',
            'max:50',
            'unique:categories,name,' . $user->id . ',id,user_id,' . $user->id
            ]
        ]);

        Auth::user()->categories()->create(['name' => $request->name]);
        return to_route('categories.index');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return Inertia::render('Category/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [ 
            'required',
            'min:2',
            'max:50',
            'unique:categories,name,' . $id
            ]
        ]);

        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);

        return to_route('categories.index');
    }

    public function destroy($id)
    {
        Category::where('user_id', Auth::user()->id)->whereId($id)->delete();

        return to_route('categories.index');
    }
}
