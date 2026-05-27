<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CatalogController extends Controller
{
    public function index(Request $request)
{
    $query = Product::with('category');

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->sort == 'name') {
        $query->orderBy('name');
    } elseif ($request->sort == 'price_asc') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort == 'price_desc') {
        $query->orderBy('price', 'desc');
    }

    $products = $query->paginate(9);
    $categories = Category::all();

    return view('catalog.index', compact('products', 'categories'));
}
}
