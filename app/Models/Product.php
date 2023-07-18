<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    /**
     * Get the user of product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
