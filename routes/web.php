<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\FetchTagController;
use App\Http\Controllers\RecipeImageController;
use App\Http\Controllers\HomemadeRecipeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomemadeRecipeController::class, 'index'])->name('welcome');
Route::get('/categoria/{category}', [HomemadeRecipeController::class,'showCategory'])->name('category.show');
Route::post('/recipes/{recipe}/like', [HomemadeRecipeController::class, 'like'])->name('recipes.like');
Route::get('/receta/{recipe}', [HomemadeRecipeController::class, 'show'])->name('showRecipe');
Route::get('/etiqueta/{tag}', [HomemadeRecipeController::class, 'showTag'])->name('tag.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('recipes', RecipeController::class);
    Route::patch('/recipes/{recipe}/update-status', [RecipeController::class, 'updateStatus'])
    ->name('recipes.update-status');
    Route::get('/fetch-tags', [FetchTagController::class, 'index'])->name('fetch-tags.index');
    Route::delete('/recipes/images/{recipeImage}', [RecipeImageController::class, 'destroy'])->name('recipes.images.destroy');


    // Recyclebin routes
    Route::get('/recyclebin', [App\Http\Controllers\RecyclebinController::class, 'index'])->name('recyclebin.index');
    Route::patch('/recyclebin/{id}/restore', [App\Http\Controllers\RecyclebinController::class, 'restore'])->name('recyclebin.restore');
    Route::delete('/recyclebin/{id}/destroy', [App\Http\Controllers\RecyclebinController::class, 'destroy'])->name('recyclebin.destroy');
});

require __DIR__.'/auth.php';


