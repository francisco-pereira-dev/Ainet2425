<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->category;
        $categories = Category::whereNull('deleted_at')->get();
        $products   = Product::with('category')
                        ->when($categoryId, fn($q)=>$q->where('category_id',$categoryId))
                        ->get();

        return view('products.index', compact('products','categories','categoryId'));
    }

    public function create()
    {
        $categories = Category::whereNull('deleted_at')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'name'              => 'required|string|max:255',
            'price'             => 'required|numeric',
            'stock'             => 'required|integer',
            'description'       => 'required|string',
            'photo'             => 'nullable|image|max:2048',
            'discount_min_qty'  => 'nullable|integer',
            'discount'          => 'nullable|numeric',
            'stock_lower_limit' => 'required|integer',
            'stock_upper_limit' => 'required|integer',
        ]);

        $data = $request->only([
            'category_id','name','price','stock','description',
            'discount_min_qty','discount','stock_lower_limit','stock_upper_limit'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products','public');
            $data['photo'] = basename($path);
        }

        Product::create($data);

        return redirect()->route('products.index')
                         ->with('success','Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        $categories = Category::whereNull('deleted_at')->get();
        return view('products.edit', compact('product','categories'));
    }

    public function update(Request $request,Product $product)
    {
        $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'name'              => 'required|string|max:255',
            'price'             => 'required|numeric',
            'stock'             => 'required|integer',
            'description'       => 'required|string',
            'photo'             => 'nullable|image|max:2048',
            'discount_min_qty'  => 'nullable|integer',
            'discount'          => 'nullable|numeric',
            'stock_lower_limit' => 'required|integer',
            'stock_upper_limit' => 'required|integer',
        ]);

        $data = $request->only([
            'category_id','name','price','stock','description',
            'discount_min_qty','discount','stock_lower_limit','stock_upper_limit'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products','public');
            $data['photo'] = basename($path);
        }

        $product->update($data);

        return redirect()->route('products.index')
                         ->with('success','Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete(); // lança o deleted_at automaticamente
        return redirect()->route('products.index')
                        ->with('success','Produto removido com sucesso!');
    }

}
