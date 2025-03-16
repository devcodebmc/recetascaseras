<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeImage extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_id', 'image_path', 'order'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
