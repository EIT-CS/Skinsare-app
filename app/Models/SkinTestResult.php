<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'skin_type', 'answers',
        'score_dry', 'score_oily', 'score_combination', 'score_sensitive',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSkinTypeLabelAttribute(): string
    {
        return match ($this->skin_type) {
            'dry'         => 'Хуурай арьс',
            'oily'        => 'Тослог арьс',
            'combination' => 'Холимог арьс',
            'normal'      => 'Хэвийн арьс',
            'sensitive'   => 'Мэдрэмтгий арьс',
            default       => 'Тодорхойгүй',
        };
    }

    public function getSkinTypeColorAttribute(): string
    {
        return match ($this->skin_type) {
            'dry'         => '#6B8CBA',
            'oily'        => '#5BA85A',
            'combination' => '#E8936A',
            'normal'      => '#9B7EC8',
            'sensitive'   => '#E8726A',
            default       => '#888',
        };
    }

    public function getSkinTypeIconAttribute(): string
    {
        return match ($this->skin_type) {
            'dry'         => '💧',
            'oily'        => '✨',
            'combination' => '⚖️',
            'normal'      => '🌸',
            'sensitive'   => '🌿',
            default       => '❓',
        };
    }
}