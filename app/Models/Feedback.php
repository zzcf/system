<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'name', 'phone', 'content', 'source', 'source_url', 'source_ip'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getLocationAttribute()
    {
        $ipData = geoip($this->source_ip)->toArray();
        return $ipData['state_name'].'-'.$ipData['city'];
    }
}
