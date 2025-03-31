<?php

namespace App\Http\Controllers;

use App\Models\RecipeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecipeImage  $recipeImage
     * @return \Illuminate\Http\Response
     */
    public function show(RecipeImage $recipeImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RecipeImage  $recipeImage
     * @return \Illuminate\Http\Response
     */
    public function edit(RecipeImage $recipeImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RecipeImage  $recipeImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecipeImage $recipeImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecipeImage  $recipeImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecipeImage $recipeImage)
    {
         // Verificar que la imagen pertenezca a la receta del usuario
        if (auth()->id() !== $recipeImage->recipe->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado para eliminar esta imagen'
            ], 403);
        }

        try {
            // Eliminar el archivo físico (ajustado a tu estructura de almacenamiento)
            $imagePath = str_replace('/storage', 'public', $recipeImage->image_path);
            
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            } else {
                // Si no existe en la ruta transformada, intentar con la ruta original
                $originalPath = str_replace('/storage', '', $recipeImage->image_path);
                if (Storage::exists('public/'.$originalPath)) {
                    Storage::delete('public/'.$originalPath);
                }
            }

            // Eliminar el registro de la imagen de la base de datos
            $recipeImage->delete();

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la imagen: ' . $e->getMessage()
            ], 500);
        }
    }
}
