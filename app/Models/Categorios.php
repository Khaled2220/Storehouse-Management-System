<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorios extends Model
{
    protected $table = 'categories'; 

    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Products::class,
            'products_categories',
            'category_id',
            'product_id'
        );
    }

    //public function products(){
    //    return $this->belongsToMany(Products::class, 'products_categories', 'category_id', 'product_id');
    //}
}
