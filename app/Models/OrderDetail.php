<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasUuids;

    use HasFactory;

    protected $table = 'shop_order_details';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_size_id',
        'quantity',
        'price',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productSize(): BelongsTo
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id', 'id');
    }
}
