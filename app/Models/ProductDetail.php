<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable = [
        'title', 'content',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
