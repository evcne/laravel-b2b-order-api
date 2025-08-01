<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'description',
        'sku',
        'price',
        'stock',
        'category_id',
        'company_id',
        'create_user_id',
        'update_user_id',
        'id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
