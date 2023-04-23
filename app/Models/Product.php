<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    // protected $fillable = ['name', 'user_id', 'image', 'price', 'quantity'];
    protected $fillable = ['name', 'user_id', 'image', 'price', 'quantity', 'category_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
