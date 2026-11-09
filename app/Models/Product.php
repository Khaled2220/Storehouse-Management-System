<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'quantity',
        'description',
        'price',
        'image',
        'status',
        'expiry_date',
        'supplier_id'
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories() :BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id');
    }

    public function supplier() :BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
        ];
    }
}
