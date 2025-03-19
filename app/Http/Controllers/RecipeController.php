<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Tag;
use App\Models\RecipeImage;
use Illuminate\Support\Facades\Storage;

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
        // Obtener el valor antiguo de 'description' si existe
        $oldDescription = old('description', '');
        $tags = Tag::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('recipes.create', compact('categories', 'oldDescription', 'tags'));
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
            'prep_time' => 'required|integer|min:1',
            'cook_time' => 'required|integer|min:1',
            'servings' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',
            'video_url' => 'nullable|url|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'secondary_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        // Subir imagen principal si se proporciona
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
            $image = Storage::url($imagePath);
        }

        // Guardar la receta
        $recipe = Recipe::create([
            'title' => $request->title,
            'description' => $request->description,
            'ingredients' => json_encode($request->ingredients),
            'steps' => json_encode($request->steps),
            'prep_time' => $request->prep_time,
            'cook_time' => $request->cook_time,
            'servings' => $request->servings,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'image' => $image,
            'video_url' => $request->video_url,
            'status' => 'draft',
        ]);

        // Guardar las tags (si se enviaron)
        if ($request->has('tags')) {
            $recipe->tags()->sync($request->tags);
        }

        // Guardar imágenes secundarias si se suben
        if ($request->hasFile('recipe_images')) {
            foreach ($request->file('recipe_images') as $key => $file) {
                $secondaryImagePath = $file->store('recipe_images', 'public');
                $secondaryImage = Storage::url($secondaryImagePath);
                
                RecipeImage::create([
                    'recipe_id' => $recipe->id,
                    'image_path' => $secondaryImage,
                    'order' => $key,
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
