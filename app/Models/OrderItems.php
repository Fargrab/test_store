<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItems extends Model
{
    use HasFactory;

    /**
     * Вызов товара из каталога
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
