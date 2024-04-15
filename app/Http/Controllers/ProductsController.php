<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $model = new Products();
        $products = $model->take(50)->get();

        return view('products.index', compact('products'));
    }
}
