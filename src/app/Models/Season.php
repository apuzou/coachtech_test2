<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    /**
     * 一括代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * 商品との多対多のリレーション
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_season');
    }
}
