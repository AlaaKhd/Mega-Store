<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $table = "comments";
    public $fillable = [
        'text' ,
        'product_id' ,
        'owner_id' ,


    ];

    public $primarykey = "id";
    public $timestamps = true;


    public function   comment(){
        return $this->belongsTo(Product::class, 'product_id');

    }

    public function   user(){
        return $this->belongsTo(User::class, 'owner_id');

    }
}

