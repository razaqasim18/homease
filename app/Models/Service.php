<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Seller;
use App\Models\Serviceimage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'category_id',
        'title',
        'description',
        'price',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function serviceImages()
    {
        return $this->hasMany(Serviceimage::class);
    }
}