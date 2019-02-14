<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'name', 'phone', 'content', 'source', 'source_url', 'source_ip'
    ];
}
