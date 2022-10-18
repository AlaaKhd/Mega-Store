<?php

namespace App\Models;
//use HasApiTokens
//use Laravel\Passport\HasApiTokens;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = "users";
    protected $fillable = [
        'name',
        'email',
        'password',
        'facebook_url',
        'phone',

    ];



    protected $primarykey = "id";
    public $timestamps = true;


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function product(){
        return $this->hasMany(Product::class, 'owner_id');
    }

    public function comment(){
        return $this->hasMany(Comment::class, 'owner_id');
    }

    public function like(){
        return $this->hasMany(like::class, 'owner_id');
    }
}
