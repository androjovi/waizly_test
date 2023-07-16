<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;    

    protected $table = 'product';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code_product',
        'name_product',
        'description_product',
        'price_product',
        'image_product',
        'flag'
    ];

    function orders()
    {
        return $this->hasMany(Order::class);
    }
}
