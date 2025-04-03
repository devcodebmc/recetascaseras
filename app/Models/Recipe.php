<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory, SoftDeletes; // Agregamos SoftDeletes

    protected $fillable = [
        'title',
        'slug',
        'description',
        'ingredients',
        'steps',
        'prep_time',
        'cook_time',
        'servings',
        'category_id',
        'user_id',
        'image',
        'video_url',
        'status',
        'likes'
    ];
    
    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
    ];

    /**
     * Genera automáticamente el slug al crear una receta.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recipe) {
            $recipe->slug = Str::slug($recipe->title);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%{$search}%")
                     ->orWhereRaw('LOWER(title) like ?', ['%' . strtolower($search) . '%']);
    }

    public function scopeFullSearch($query, $searchTerm)
    {
        return $query->where(function($q) use ($searchTerm) {
            $preparedTerm = $this->prepareSearchTerm($searchTerm);
            
            // Verificar si el término coincide exactamente con una categoría
            $isExactCategoryMatch = Category::whereRaw(
                "name ILIKE ?", ["%{$searchTerm}%"]
            )->exists();
            
            if ($isExactCategoryMatch) {
                // Si es una categoría exacta, buscar solo por categoría
                $q->whereHas('category', function($q) use ($searchTerm) {
                    $q->whereRaw("name ILIKE ?", ["%{$searchTerm}%"]);
                });
            } else {
                // Búsqueda normal en todos los campos
                $q->where(function($subQuery) use ($preparedTerm) {
                    $subQuery->whereRaw("to_tsvector('spanish', title) @@ to_tsquery('spanish', ?)", [$preparedTerm])
                            ->orWhereRaw("to_tsvector('spanish', ingredients) @@ to_tsquery('spanish', ?)", [$preparedTerm]);
                })
                ->orWhereHas('category', function($q) use ($preparedTerm) {
                    $q->whereRaw("to_tsvector('spanish', name) @@ to_tsquery('spanish', ?)", [$preparedTerm]);
                });
            }
        });
    }

    protected function prepareSearchTerm($term)
    {
        $normalized = mb_strtolower(trim($term), 'UTF-8');
        $words = preg_split('/\s+/', $normalized);
        $words = array_filter($words);
        
        if (empty($words)) {
            return 'nada';
        }
        
        return implode(' & ', $words) . ':*';
    }

    // Scope para ordenamiento
    public function scopeOrderBySelection($query, $sortOption)
    {
        return match ($sortOption) {
            'antiguos' => $query->orderBy('created_at', 'asc'),
            'populares' => $query->orderBy('likes', 'desc')->orderBy('created_at', 'desc'),
            default => $query->orderBy('created_at', 'desc'), // 'nuevos' por defecto
        };
    }

    /**
     * Relación con la categoría (Muchas recetas pertenecen a una categoría).
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relación con el usuario (Muchas recetas pertenecen a un usuario).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con etiquetas (Muchos a muchos).
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'recipe_tags');
    }

    /**
     * Relación con imágenes de la receta (Una receta tiene muchas imágenes).
     */
    public function images()
    {
        return $this->hasMany(RecipeImage::class);
    }
}
