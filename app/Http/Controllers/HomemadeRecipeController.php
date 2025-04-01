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
        $recipes = Recipe::orderBy('created_at', 'asc')->limit(7)->get();
        $categories = Category::select('id', 'name', 'icon_url', 'description')->orderBy('name', 'asc')->get();
        $tags = Tag::select('id', 'name')->orderBy('name', 'asc')->limit(10)->get();
        return view('welcome', compact('categories', 'recipes', 'tags'));
    }
}
