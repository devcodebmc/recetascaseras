<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Recipe;

class HomemadeRecipeController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name', 'icon_url', 'description')->orderBy('name', 'asc')->get();
        $recipes = Recipe::orderBy('created_at', 'asc')->limit(4)->get();
        return view('welcome', compact('categories', 'recipes'));
    }
}
