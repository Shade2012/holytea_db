<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_menu',
        'name_menu',
        'price_menu',
        'category_menu',
        'rating_menu',
        'description_menu',
    ];

    // Create an accessor for the image_menu attribute
    protected function imageMenu(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => $image ? url('/images/menu/'.$image) : null,
        );
    }
}
