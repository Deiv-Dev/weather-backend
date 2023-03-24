<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
        'weather',
    ];

    protected $table = 'weathers';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_weather');
    }
}