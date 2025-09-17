<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * 一括代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
    ];

    /**
     * 季節との多対多のリレーション
     */
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }
}
