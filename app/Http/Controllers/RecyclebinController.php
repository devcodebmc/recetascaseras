<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;

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
    public function destroy($id)
    {
        // Buscar la receta (incluyendo las eliminadas con soft delete)
        $recipe = Recipe::withTrashed()->where('id', $id)->first();

        // Verificar si la receta existe
        if (!$recipe) {
            return redirect()->route('recipes.index')->with('error', 'Receta no encontrada');
        }

        try {
            // Desasociar etiquetas
            $recipe->tags()->detach();

            // Eliminar la imagen principal de la receta si existe
            if ($recipe->image) {
                // Eliminar el prefijo "/storage" de la ruta
                $imagePath = str_replace('/storage', 'public', $recipe->image);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            // Eliminar imágenes asociadas y sus archivos
            $images = $recipe->images;
            foreach ($images as $image) {
                // Eliminar el prefijo "/storage" de la ruta
                $imagePath = str_replace('/storage', 'public', $image->image_path);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
                // Eliminar el registro de la imagen de la base de datos
                $image->delete();
            }

            // Forzar la eliminación de la receta (incluyendo soft delete)
            $recipe->forceDelete();

            // Redirigir con mensaje de éxito
            return redirect()->route('recipes.index')->with('success', 'Receta eliminada correctamente');
        } catch (\Exception $e) {
            // Manejar errores y redirigir con mensaje de error
            return redirect()->route('recipes.index')->with('error', 'Error al eliminar la receta: ' . $e->getMessage());
        }
    }
    
}
