<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "title", 
        "slug", 
        "description",
        "price",
        "image"
    ];

    protected $casts = [
        "price" => "decimal:2",
        
    ];
}
