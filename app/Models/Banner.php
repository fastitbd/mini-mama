<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'bg_color',
        'btn_text',
        'btn_url',
        'banner_type',
        'order_num',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order_num' => 'integer',
    ];

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('frontend/images/placeholder.png');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, '//')) {
            return $this->image;
        }

        if (file_exists(public_path('uploads/banners/' . $this->image))) {
            return asset('uploads/banners/' . $this->image);
        }

        if (file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        return asset('uploads/banners/' . $this->image);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_num', 'asc')->orderBy('id', 'asc');
    }
}
