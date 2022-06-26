<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'title',
        'content',
        'image',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}