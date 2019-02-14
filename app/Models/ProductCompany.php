<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCompany extends Model
{
    protected $fillable = [
        'name', 'simple_name', 'english_name', 'logo',
        'background', 'capital', 'scale', 'create_date',
        'city', 'chairman', 'top_manager', 'representative',
        'stock_holder', 'is_list', 'content',
    ];

    protected $casts = [
        'is_list' => 'boolean',
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
