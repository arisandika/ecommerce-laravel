<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasUuids;

    use HasFactory;

    protected $table = 'shop_product_sizes';

    protected $fillable = [
        'product_id',
        'size_id',
        'quantity',
        'size_price',
    ];

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }
}
