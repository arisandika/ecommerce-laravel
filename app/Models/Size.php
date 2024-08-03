<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasUuids;

    use HasFactory;

    protected $table = 'shop_sizes';

    protected $fillable = [
        'id',
        'name',
        'code',
        'visibility',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'size_id', 'id');
    }
}
