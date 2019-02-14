<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'title', 'name', 'content', 'status', 'order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function companies()
    {
        return $this->hasMany(ProductCompany::class, 'category_id');
    }
}
