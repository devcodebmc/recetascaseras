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
 
        // Verificar si el usuario está autenticado
       if (!auth()->check()) {
           return redirect()->route('login'); // O manejar usuarios no autenticados
       }
       
       // Base query con ordenación y búsqueda
       $query = Recipe::orderBy('updated_at', 'DESC')->search($search);
       
       // Filtrar según el rol del usuario
       if (auth()->user()->role === 'user') {
           $query->where('user_id', auth()->id()); // Solo recetas del usuario actual
       }
       // Los roles 'admin' y 'editor' ven todas las recetas sin filtro
       
       $recipes = $query->paginate(5);

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
            'recipe_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
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
        $recipe = Recipe::with(['category', 'tags', 'images'])->findOrFail($id);

        // Validar autenticación
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Validar roles y propiedad de la receta
        if (auth()->user()->role === 'user' && $recipe->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar esta receta.');
        }

        // Los roles 'admin' y 'editor' pueden editar cualquier receta
        $categories = Category::all();
        $tags = Tag::all();

        // Convertir ingredientes a array si es necesario
        $ingredients = $this->convertToArray($recipe->ingredients);

        // Convertir pasos a array si es necesario
        $steps = $this->convertToArray($recipe->steps);

        // Obtener el valor antiguo de 'description' si existe
        $oldDescription = old('description', '');

        return view('recipes.edit', compact('recipe', 'categories', 'tags', 'ingredients', 'steps', 'oldDescription'));
    }

    // Función auxiliar para convertir a array
    protected function convertToArray($data)
    {
        if (is_array($data)) {
            return $data;
        }
        
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            return is_array($decoded) ? $decoded : [$data];
        }
        
        if (is_object($data)) {
            return (array)$data;
        }
        
        return [];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        // Validar autenticación
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Validar roles y propiedad de la receta
        if (auth()->user()->role === 'user' && $recipe->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar esta receta.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'required|array|min:1',
            'steps' => 'required|array',
            'prep_time' => 'required|integer|min:1',
            'cook_time' => 'required|integer|min:1',
            'servings' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'video_url' => 'nullable|url|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'recipe_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        // Procesar imagen principal si se cambió
        $image = $recipe->image;
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($recipe->image) {
                $oldImagePath = str_replace('/storage', 'public', $recipe->image);
                Storage::delete($oldImagePath);
            }

            // Subir la nueva imagen
            $imagePath = $request->file('image')->store('recipes', 'public');
            $image = Storage::url($imagePath);
        }

        // Actualizar la receta
        $recipe->update([
            'title' => $request->title,
            'description' => $request->description,
            'ingredients' => json_encode($request->ingredients),
            'steps' => json_encode($request->steps),
            'prep_time' => $request->prep_time,
            'cook_time' => $request->cook_time,
            'servings' => $request->servings,
            'category_id' => $request->category_id,
            'image' => $image,
            'video_url' => $request->video_url,
        ]);

        // Sincronizar tags
        if ($request->has('tags')) {
            $recipe->tags()->sync($request->tags);
        }

        // Añadir nuevas imágenes secundarias
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

        return redirect()->route('recipes.index', $recipe->id)
            ->with('success', 'Receta actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Validar autenticación
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $recipe = Recipe::findOrFail($id);

        // Validar roles y propiedad de la receta
        if (auth()->user()->role === 'user' && $recipe->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar esta receta.');
        }

        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Receta enviada a la papelera correctamente.');
    }

    public function updateStatus(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'new_status' => 'required|in:published,draft'
        ]);
        
        $recipe->update(['status' => $validated['new_status']]);
        
        return back()->with('success', 'Estado actualizado correctamente');
    }
}
