<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Products extends Model
{
  
   protected $fillable = [
    'user_id',
    'name',
    'quantity',
    'description',
    'price',
    'image',
];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function categories(){
        return $this->belongsToMany( Categorios::class, 'products_categories', 'product_id', 'category_id');
    }
}
