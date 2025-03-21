<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecyclebinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::onlyTrashed()->orderBy('deleted_at', 'DESC')->paginate(10);
        return view('recyclebin.index', compact('recipes'));
    }

    public function restore($id)
    {
        $recipe = Recipe::withTrashed()->where('id', $id)->first();
        $recipe->restore();
        return redirect()->route('recipes.index')->with('success', 'Receta restaurada correctamente');
    }
    
}
