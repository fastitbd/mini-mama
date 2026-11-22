<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'subtitle',
        'icon',
        'badge_text',
        'color',
        'order_num',
        'status',
        'is_system',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_system' => 'boolean',
        'order_num' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_num', 'asc')->orderBy('id', 'asc');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'section', 'key');
    }
}
