<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids;

    use HasFactory;

    protected $table = 'shop_categories';

    protected $fillable = [
        'name',
        'slug',
        'visibility',
        'image',
    ];
    
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
