<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = ['name',];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany( Product::class,
            'products_categories',
            'category_id',
            'product_id'
        );
    }

    // public function products(){
    //    return $this->belongsToMany(Products::class, 'products_categories', 'category_id', 'product_id');
    // }
}
