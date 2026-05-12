<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'image', 'category', 'suitable_for', 'brand', 'rating', 'is_active',
    ];

    protected $casts = [
        'suitable_for' => 'array',
        'is_active'    => 'boolean',
        'price'        => 'decimal:2',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'cleanser'    => 'Цэвэрлэгч',
            'toner'       => 'Тонер',
            'moisturizer' => 'Чийгшүүлэгч',
            'serum'       => 'Серум',
            'sunscreen'   => 'Нарнаас хамгааллах',
            'mask'        => 'Маск',
            'spot'        => 'Батга эмчлэгч',
            'eye_cream'   => 'Нүдний тос',
            default       => $this->category,
        };
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }
        return asset('images/product-placeholder.png');
    }

    public function scopeForSkinType($query, string $skinType)
    {
        return $query->whereJsonContains('suitable_for', $skinType)->where('is_active', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
