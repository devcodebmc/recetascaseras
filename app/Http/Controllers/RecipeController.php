<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Tag;
use App\Models\RecipeTag;
use App\Models\RecipeImage;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $recipes = Recipe::OrderBy('updated_at', 'DESC')->search($search)->paginate(5);
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        $tags = Tag::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('recipes.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required|array',
            'ingredients.*' => 'string|max:255',
            'steps' => 'required|array',
            'steps.*' => 'string|max:1000',
            'prep_time' => 'nullable|integer|min:1',
            'cook_time' => 'nullable|integer|min:1',
            'servings' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'video_url' => 'nullable|url|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'secondary_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        // Subir imagen principal si se proporciona
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
        }

        // Guardar la receta
        $recipe = Recipe::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'ingredients' => json_encode($request->ingredients),
            'steps' => json_encode($request->steps),
            'prep_time' => $request->prep_time,
            'cook_time' => $request->cook_time,
            'servings' => $request->servings,
            'image' => $imagePath,
            'video_url' => $request->video_url,
        ]);

        // Guardar las tags (si se enviaron)
        if ($request->has('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $recipe->tags()->sync($tagIds);
        }

        // Guardar imágenes secundarias si se suben
        if ($request->hasFile('secondary_images')) {
            foreach ($request->file('secondary_images') as $file) {
                $secondaryImagePath = $file->store('recipe_images', 'public');

                RecipeImage::create([
                    'recipe_id' => $recipe->id,
                    'image_path' => $secondaryImagePath,
                ]);
            }
        }

        return redirect()->route('recipes.index')->with('success', 'Receta creada con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
