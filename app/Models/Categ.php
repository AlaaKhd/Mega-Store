<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categ extends Model
{

    protected $table = "categs";
    protected $fillable = [

        'name',

    ];
    protected $primarykey = "id";
    public $timestamps = true;

    public function   product(){
        return $this->hasMany(Product::class, 'category_id');
    }


}
