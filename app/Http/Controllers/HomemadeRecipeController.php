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
        // Recoger los parámetros de búsqueda y ordenamiento
        $search = $request->input('searchfull');
        $sortOption = $request->input('sort', 'nuevos'); // Valor por defecto 'nuevos'
        
        $recipes = Recipe::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->when($search, function ($query, $search) {
                $query->fullSearch($search);
            })
            ->orderBySelection($sortOption)
            ->limit(9)
            ->get();
        
    
        $images = Recipe::with('user')
                ->select('id', 'title', 'image', 'likes', 'user_id')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->orderBy('likes', 'desc')
                ->limit(9)
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

        // Obtener el top 3 de cocineros de acuerdo a la cantidad de recetas en la base de datos
        $topChefs = Recipe::selectRaw('user_id, COUNT(*) as recipe_count')
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->groupBy('user_id')
            ->orderByDesc('recipe_count')
            ->with('user:id,name') // Cargar información del usuario
            ->limit(3)
            ->get();
    
        $categories = Category::select('id', 'name', 'slug', 'icon_url', 'description')->orderBy('name', 'asc')->get();
        $tags = Tag::select('id', 'name')->orderBy('name', 'asc')->limit(10)->get();
        
        return view('welcome', compact('recipes', 'images', 'stories', 'userRecipes', 'categories', 'tags', 'topChefs'));
    }

    public function like(Recipe $recipe)
    {
        $recipe->likes += 1;
        $recipe->save();

        return response()->json([
            'success' => true,
            'likes' => $recipe->likes
        ]);
    }

    public function showCategory($category)
    {
        $recipes = Recipe::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where('category_id', Category::where('slug', $category)->first()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

             // Obtener historias (última receta de cada usuario)
        $stories = Recipe::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where('category_id', Category::where('slug', $category)->first()->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('user_id');

        // Obtener TODAS las recetas agrupadas por usuario para el modal
        $userRecipes = Recipe::with('user:id,name','category', 'tags')
            ->select('id', 'title', 'image', 'user_id')
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where('category_id', Category::where('slug', $category)->first()->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(function($recipes) {
                return $recipes->take(10); // Limitar a 10 recetas por usuario
            });

        $categories = Category::select('id', 'name', 'slug', 'icon_url', 'description')->orderBy('name', 'asc')->get();

        $tags = Tag::select('id', 'slug', 'name')->get()->shuffle();

        return view('frontend.pages.categorias', compact('recipes', 'stories', 'userRecipes', 'categories', 'tags'));
    }
    public function show($slug)
    {
        $recipe = Recipe::with(['user', 'category', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->firstOrFail();
        
        $smallRecipes = Recipe::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where('id', '!=', $recipe->id)
            ->inRandomOrder()
            ->take(6)
            ->get();

        $categories = Category::select('id', 'name', 'slug', 'icon_url', 'description')
            ->orderBy('name', 'asc')->get();

        $tags = Tag::select('id', 'slug', 'name')->get()->shuffle();

        return view('frontend.posts.recipe', compact('recipe', 'smallRecipes', 'categories', 'tags'));
    }

    public function showTag($tag)
    {
        $recipes = Recipe::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('slug', $tag);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $smallRecipes = Recipe::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->inRandomOrder()
            ->take(6)
            ->get();

        $tag = Tag::where('slug', $tag)->firstOrFail();

        $categories = Category::select('id', 'name', 'slug', 'icon_url', 'description')->orderBy('name', 'asc')->get();
        $tags = Tag::select('id', 'name')->get()->shuffle();
        
        return view('frontend.posts.tag', compact('recipes', 'smallRecipes', 'tag', 'categories', 'tags'));
    }

    public function userRecipes($user)
    {
        $recipes = Recipe::with(['user', 'category', 'tags'])
            ->where('user_id', $user)
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $stories = Recipe::with(['user', 'category', 'tags'])
            ->where('user_id', $user)
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('user_id');

        $userRecipes = Recipe::with('user:id,name','category', 'tags')
            ->select('id', 'title', 'image', 'user_id')
            ->where('user_id', $user)
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(function($recipes) {
                return $recipes->take(10); // Limitar a 10 recetas por usuario
            });

        $categories = Category::select('id', 'name', 'slug', 'icon_url', 'description')->orderBy('name', 'asc')->get(); 
        $tags = Tag::select('id', 'name')->get()->shuffle();

        return view('frontend.posts.user', compact('recipes', 'stories', 'userRecipes', 'categories', 'tags'));
    }
}
