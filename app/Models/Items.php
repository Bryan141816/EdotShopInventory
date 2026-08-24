<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'cost_price',
        'selling_price',
        'quantity',
        'image',
        'is_active',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(PartBrands::class, 'brand_id');
    }
    public function category()
    {
        return $this->belongsTo(PartCategory::class, 'category_id');
    }
}

