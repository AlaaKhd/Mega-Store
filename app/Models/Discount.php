<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public $table = "discounts";
    public $fillable = [

        'product_id',
        'discount_percentage',
        'date',

    ];
    public $primarykey = "id";
    public $timestamps = true;

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id')->orderBy('date');
    }
}
