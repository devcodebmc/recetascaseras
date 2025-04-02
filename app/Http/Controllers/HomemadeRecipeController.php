<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tag;

class HomemadeRecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('user')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')
                ->limit(8)
                ->get();
    
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
    
        $categories = Category::select('id', 'name', 'icon_url', 'description')->orderBy('name', 'asc')->get();
        $tags = Tag::select('id', 'name')->orderBy('name', 'asc')->limit(10)->get();
        
        return view('welcome', compact('recipes', 'stories', 'userRecipes', 'categories', 'tags'));
    }
   
}
