<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'suitable_for', 'category', 'icon', 'is_active',
    ];

    protected $casts = [
        'suitable_for' => 'array',
        'is_active'    => 'boolean',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'morning_routine' => 'Өглөөний арчилгаа',
            'evening_routine' => 'Оройн арчилгаа',
            'diet'            => 'Хоол тэжээл',
            'lifestyle'       => 'Амьдралын хэв маяг',
            'acne_treatment'  => 'Батга эмчлэлт',
            default           => $this->category,
        };
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