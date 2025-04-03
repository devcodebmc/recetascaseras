<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tag;

class HomemadeRecipeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('searchfull');

        $recipes = Recipe::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->when($search, function ($query, $search) {
                $query->fullSearch($search);
            })
            ->orderBy('created_at', 'desc')
            ->limit(9)
            ->get();
    
        // $recipes = Recipe::with('user')
        //         ->where('status', 'published')
        //         ->whereNull('deleted_at')
        //         ->orderBy('created_at', 'desc')
        //         ->limit(9)
        //         ->get();
    
        // Obtener historias (última receta de cada usuario)
        $stories = Recipe::with('user:id,name')
                ->select('id', 'title', 'image', 'user_id')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'desc')
                ->get()
                ->unique('user_id');
    
        // Obtener TODAS las recetas agrupadas por usuario para el modal
        $userRecipes = Recipe::with('user:id,name')
                ->select('id', 'title', 'image', 'user_id')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('user_id')
                ->map(function($recipes) {
                    return $recipes->take(10); // Limitar a 10 recetas por usuario
                });

        // Obtener el top 3 de cocineros de acuerdo a la cantidad de recetas en la base de datos
        $topChefs = Recipe::selectRaw('user_id, COUNT(*) as recipe_count')
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->groupBy('user_id')
            ->orderByDesc('recipe_count')
            ->with('user:id,name') // Cargar información del usuario
            ->limit(3)
            ->get();
    
        $categories = Category::select('id', 'name', 'icon_url', 'description')->orderBy('name', 'asc')->get();
        $tags = Tag::select('id', 'name')->orderBy('name', 'asc')->limit(10)->get();
        
        return view('welcome', compact('recipes', 'stories', 'userRecipes', 'categories', 'tags', 'topChefs'));
    }

    public function like(Recipe $recipe)
    {
        $recipe->increment('likes');
        return response()->json([
            'success' => true,
            'likes' => $recipe->likes
        ]);
    }
   
}
