<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tags = Tag::OrderBy('updated_at', 'DESC')->search($search)->paginate(5);
        return view('tags.index', compact('tags'));
    }

    public function indexAction()
    {
        $tags = Tag::select('id', 'name')->get(); // Obtener todas las etiquetas
        return response()->json($tags); // Devolver como JSON
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
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
            'name' => ['required', 'string','max:255', 'unique:tags'],
        ]);

        Tag::create($request->all());
        return redirect()->route('tags.index')->with('success', 'Etiqueta creada correctamente.');
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
        // Validar los datos de la solicitud
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags,name,'.$id],
        ]);
    
        // Encontrar la etiqueta por su ID y actualizar solo el nombre
        $tag = Tag::findOrFail($id);
        $tag->name = $request->input('name');
        $tag->save();
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('tags.index')->with('success', 'Etiqueta actualizada correctamente.');
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Etiqueta eliminada correctamente.');
    }
}
