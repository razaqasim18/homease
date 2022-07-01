<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'seller_id',
        'buyer_id',
        'hiring_id',
        'rating',
        'comment',
    ];
}