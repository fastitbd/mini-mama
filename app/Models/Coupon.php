<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'status' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function isValidForAmount($subtotal)
    {
        if (!$this->status) return false;
        if ($this->min_order_amount > 0 && $subtotal < $this->min_order_amount) return false;
        if ($this->end_date && now()->gt($this->end_date)) return false;
        if ($this->start_date && now()->lt($this->start_date)) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if (!$this->isValidForAmount($subtotal)) return 0;

        if ($this->discount_type === 'percentage') {
            $discount = ($subtotal * $this->discount_value) / 100;
            if ($this->max_discount_amount > 0 && $discount > $this->max_discount_amount) {
                $discount = $this->max_discount_amount;
            }
            return round($discount, 2);
        } else {
            return min($subtotal, $this->discount_value);
        }
    }
}
