<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasUuids;

    use HasFactory;

    protected $table = 'shop_product_images';

    protected $fillable = [
        'product_id',
        'image',
        'slug',
    ];
}
