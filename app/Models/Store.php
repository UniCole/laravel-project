<?php

namespace App\Models;

use App\Models\Product;
use App\Models\User;

class Store extends User
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}