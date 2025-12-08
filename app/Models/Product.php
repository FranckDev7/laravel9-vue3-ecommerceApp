<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    // Le produit peut apparaître dans plusieurs commandes
    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('total_quantity', 'total_price');
    }

    // Attribute : Create a new attribute accessor / mutator.
/*    public function price() : Attribute
    {
        return Attribute::make(
            get: static fn($value) => str_replace('.', ',', $value / 100) . " $",
        );
    }*/

    public function getFormattedPriceAttribute(): string
    {
        return str_replace('.', ',', $this->price / 100) . " $";
    }

    // Attribute : Create a new attribute accessor / mutator.
/*    public function holdPrice() : Attribute
    {
        return Attribute::make(
            get: static fn($value) => str_replace('.', ',', $value / 100) . " $",
        );
    }*/

    public function getFormatedHoldPriceAttribute(): string
    {
        return str_replace('.', ',', $this->hold_price / 100) . " $";
    }
}
