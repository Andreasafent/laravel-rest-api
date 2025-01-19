<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        "name", 
        "slug",
        "brand_id",
        "logo"
    ];

    protected $hidden = [
        "created_at", 
        "updated_at"
    ];

    public function products(): HasMany{
        return $this->hasMany(Product::class); // belongsToMany Product, with foreign key "category_id"
    }
}
