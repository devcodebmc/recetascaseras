<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            $tag->slug = Str::slug($tag->name);
        });

        static::updating(function ($tag) {
            $tag->slug = Str::slug($tag->name);
        });
    }
    
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_tags', 'tag_id', 'recipe_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%']);
    }

    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
    
}
