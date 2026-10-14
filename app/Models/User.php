<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


#[Fillable(['full_name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


   protected $fillable = [
        'full_name', 
        'email',
        'password',
        //'is_admin'
        'user_type',
    ];
      protected $hidden = [
        'password',
        'remember_token',
    ];


    public function products(){
        return $this->hasMany(Products::class);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            //'is_admin' => 'boolean',
            'user_type' => 'integer',
        ];
    }
}
