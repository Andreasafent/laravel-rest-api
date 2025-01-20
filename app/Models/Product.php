<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        "title", 
        "slug",
        "category_id",
        "brand_id",
        "description",
        "price",
        "image"
    ];

    protected $casts = [
        "price" => "decimal:2",
        
    ];

    protected $hidden=[
        "category_id",
        "brand_id"
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo{
        return $this->belongsTo(Brand::class);
    }
}
