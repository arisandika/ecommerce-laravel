<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids;

    use HasFactory;

    protected $table = 'shop_products';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'brand',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'quantity',
        'weight',
        'trending',
        'featured',
        'visibility',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
    
    public function productSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id', 'id');
    }
    
    public function productCart()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }
}
