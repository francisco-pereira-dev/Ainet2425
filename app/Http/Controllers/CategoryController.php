<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('deleted_at')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'name'  => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories','public');
            // Guarda apenas o nome do ficheiro:
            $data['image'] = basename($path);
        }

        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Categoria criada!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
        'name'  => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('image')) {
            // Apaga antiga
            if ($category->image) {
                Storage::disk('public')->delete('categories/'.$category->image);
            }
            $path = $request->file('image')->store('categories','public');
            $data['image'] = basename($path);
        }

        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Categoria atualizada!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }


    public function destroy(Category $category)
    {
        // elimina (soft-delete) e apaga a imagem
        if ($category->image) {
            Storage::disk('public')->delete('categories/'.$category->image);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoria eliminada!');
    }
}
