<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::OrderBy('updated_at', 'DESC')->search($search)->paginate(5);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon_url' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle the file upload using Storage
        if ($request->hasFile('icon_url')) {
            $file = $request->file('icon_url');
            $path = $file->store('public/images/categories');
            $icon_url = Storage::url($path);
        }

        // Create a new category
        $category               = new Category;
        $category->name         = $request->name;
        $category->description  = $request->description;
        $category->icon_url     = $icon_url;
        $category->save();

        // Redirect to the categories index
        return redirect()->route('categories.index')->with('success', 'Categoría creada correctamente.');
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
        $category = Category::findorFail($id);
        return view('categories.edit', compact('category'));
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
        // Validate the request
        $request->validate([
            'name' => ['required','string','max:255'],
            'icon_url' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle the file upload using Storage
        if ($request->hasFile('icon_url')) {
            $category = Category::find($id);
            // Delete the old image
            if ($category->icon_url) {
            $oldImagePath = str_replace('/storage', 'public', $category->icon_url);
            Storage::delete($oldImagePath);
            }
            // Store the new image
            $file = $request->file('icon_url');
            $path = $file->store('public/images/categories');
            $icon_url = Storage::url($path);
        } else {
            $icon_url = Category::find($id)->icon_url;
        }

        // Update the category
        $category               = Category::find($id);
        $category->name         = $request->name;
        $category->description  = $request->description;
        $category->icon_url     = $icon_url;
        $category->save();

        // Redirect to the categories index
        return redirect()->route('categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete the category's image
        $category = Category::find($id);

        // Eliminar el prefijo "/storage" de la ruta
        $imagePath = str_replace('/storage', 'public', $category->icon_url);
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
        // Delete the category
        Category::destroy($id);
        // Redirect to the categories index
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
