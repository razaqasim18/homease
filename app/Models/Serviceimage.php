<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serviceimage extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'image',
    ];

    public function service()
    {
        $this->belongsTo(Service::class);
    }
}