<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasUuids;
    
    use HasFactory;

    protected $table = 'shop_orders';

    protected $fillable = [
        'user_id',
        'tracking_no',
        'fullname',
        'email',
        'phone',
        'postcode',
        'address',
        'subtotal_price',
        'shipping_cost',
        'total_price',
        'status_order',
        'payment_method',
        'snap_token',
        'payment_id',
    ];

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
