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
        // Base query para recetas eliminadas
        $query = Recipe::onlyTrashed()->orderBy('deleted_at', 'DESC');
        
        // Si el usuario es 'user', solo verá sus propias recetas eliminadas
        if (auth()->user()->role === 'user') {
            $query->where('user_id', auth()->id());
        }
        // Admin y editor ven todas las recetas eliminadas
        
        $recipes = $query->paginate(10);
        return view('recyclebin.index', compact('recipes'));
    }

    public function restore($id)
    {
        $recipe = Recipe::withTrashed()->where('id', $id)->first();
        
        // Verificar existencia y permisos
        if (!$recipe) {
            return redirect()->route('recyclebin.index')->with('error', 'Receta no encontrada');
        }
        
        // Solo el propietario o admin/editor pueden restaurar
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'editor' && $recipe->user_id !== auth()->id()) {
            return redirect()->route('recyclebin.index')->with('error', 'No tienes permiso para restaurar esta receta');
        }
        
        $recipe->restore();
        return redirect()->route('recipes.index')->with('success', 'Receta restaurada correctamente');
    }

    public function destroy($id)
    {
        $recipe = Recipe::withTrashed()->where('id', $id)->first();

        if (!$recipe) {
            return redirect()->route('recyclebin.index')->with('error', 'Receta no encontrada');
        }
        
        // Verificar permisos para eliminación permanente
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'editor' && $recipe->user_id !== auth()->id()) {
            return redirect()->route('recyclebin.index')->with('error', 'No tienes permiso para eliminar esta receta');
        }

        try {
            // Desasociar etiquetas
            $recipe->tags()->detach();

            // Eliminar imagen principal
            if ($recipe->image) {
                $imagePath = str_replace('/storage', 'public', $recipe->image);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            // Eliminar imágenes asociadas
            $images = $recipe->images;
            foreach ($images as $image) {
                $imagePath = str_replace('/storage', 'public', $image->image_path);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
                $image->delete();
            }

            // Eliminación permanente
            $recipe->forceDelete();

            return redirect()->route('recyclebin.index')->with('success', 'Receta eliminada definitivamente');
        } catch (\Exception $e) {
            return redirect()->route('recyclebin.index')->with('error', 'Error al eliminar la receta: ' . $e->getMessage());
        }
    }
}