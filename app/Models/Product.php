<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public static $raiseMap = [
        1 => '在售',
        0 => '售罄'
    ];

    public static $profitMap = [
        1 => '7%以下',
        2 => '7%（含）-9%',
        3 => '9%（含）-10%',
        4 => '10%（含）以上'
    ];

    public static $termMap = [
        1 => '12个月以内',
        2 => '12个月（含）-24个月（含）',
        3 => '24个月以上'
    ];

    public static $investDirectionMap = [
        1 => '政信项目',
        2 => '工商企业',
        3 => '房地产',
        4 => '金融市场',
        5 => '资金池',
        6 => '其他'
    ];

    public static $interestTypeMap = [
        1 => '按月付息',
        2 => '按季付息',
        3 => '半年付息',
        4 => '按年付息',
        5 => '到期付息',
        6 => '其他'
    ];


    protected $fillable = [
        'name', 'full_name', 'description', 'profit',
        'profit_min_value', 'profit_max_value', 'profit_description',
        'term', 'term_min_value', 'term_max_value',
        'invest_direction', 'interest_type', 'min_invest', 'collect_size',
        'status', 'order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function company()
    {
        return $this->belongsTo(ProductCompany::class, 'company_id');
    }

    public function details()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
    }
}
