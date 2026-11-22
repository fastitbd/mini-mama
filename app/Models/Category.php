<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id')->orderBy('order_num', 'asc')->orderBy('id', 'asc');
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return asset('frontend/images/placeholder.png');
        }
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, '//')) {
            return $this->image;
        }
        return asset('uploads/categories/' . $this->image);
    }
}

