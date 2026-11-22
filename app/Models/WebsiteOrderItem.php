<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteOrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(WebsiteOrder::class, 'website_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function getImageUrlAttribute()
    {
        if (!empty($this->product_image)) {
            if (str_starts_with($this->product_image, 'http://') || str_starts_with($this->product_image, 'https://') || str_starts_with($this->product_image, '//')) {
                return $this->product_image;
            }
            if (file_exists(public_path('uploads/products/' . $this->product_image))) {
                return asset('uploads/products/' . $this->product_image);
            }
            if (file_exists(public_path($this->product_image))) {
                return asset($this->product_image);
            }
            return asset('uploads/products/' . $this->product_image);
        }

        if ($this->product && $this->product->image_url) {
            return $this->product->image_url;
        }

        return asset('frontend/images/placeholder.png');
    }
}
