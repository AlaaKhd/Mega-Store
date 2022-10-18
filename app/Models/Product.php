<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = "products";
    public $fillable = [
        'name',
        'price',
        'current_price',
        'description',
        'img_url',
        'quantity',
        'exp_date',
        'category_id',
        'phone_number',
        'owner_id',
        'viwes',

    ];

    public $primarykey = "id";
    public $timestamps = true;




    public function   user(){
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function   like(){
        return $this->hasMany(like::class, 'product_id');
    }

    public function   comments(){
        return $this->hasMany(Comment::class, 'product_id');
    }

    public function   categ(){
        return $this->belongsTo(categ::class, 'category_id');
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'product_id')->orderBy('date');
    }
}
