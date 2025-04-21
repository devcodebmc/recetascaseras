<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/search/suggestions', function (Request $request) {
    $query = trim($request->input('q'));
    
    if (strlen($query) < 2) {
        return response()->json([]);
    }
    
    $cacheKey = 'search:suggestions:' . md5($query);
    $expiration = now()->addMinutes(5);
    
    return Cache::remember($cacheKey, $expiration, function() use ($query) {
        // Prepara el término para búsqueda por prefijo
        $searchTerm = str_replace(' ', ' & ', $query) . ':*';
        
        // Búsqueda en recetas (títulos)
        $recipes = DB::table('recipes')
            ->select('title')
            ->whereRaw("to_tsvector('spanish', title) @@ to_tsquery('spanish', ?)", [$searchTerm])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->pluck('title')
            ->toArray();
        
        // Búsqueda en categorías
        $categories = DB::table('categories')
            ->select('name')
            ->whereRaw("to_tsvector('spanish', name) @@ to_tsquery('spanish', ?)", [$searchTerm])
            ->limit(3)
            ->pluck('name')
            ->toArray();
        
        $suggestions = array_unique(array_merge($recipes, $categories));
        
        // Ordenar por coincidencia más exacta primero
        usort($suggestions, function($a, $b) use ($query) {
            $aStarts = str_starts_with(mb_strtolower($a), mb_strtolower($query)) ? 0 : 1;
            $bStarts = str_starts_with(mb_strtolower($b), mb_strtolower($query)) ? 0 : 1;
            return $aStarts - $bStarts;
        });
        
        return array_slice($suggestions, 0, 8);
    });
})->name('search.suggestions');