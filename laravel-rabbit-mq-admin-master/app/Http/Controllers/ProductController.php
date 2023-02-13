<?php

namespace App\Http\Controllers;

use App\Jobs\ProductCreated;
use App\Jobs\ProductDeleted;
use App\Jobs\ProductUpdated;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show($product)
    {
        return Product::find($product);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->only('title', 'image'));

        ProductCreated::dispatch($product->toArray())->onQueue('main_queue');

        return response($product, Response::HTTP_CREATED);
    }

    public function update(Request $request, $product)
    {
        $product = Product::find($product);

        $product->update($request->only('title', 'image'));
       // return response($product, 200);
        ProductUpdated::dispatch($product->toArray())->onQueue('main_queue');

        return response($product, Response::HTTP_ACCEPTED);
    }

    public function destroy($product)
    {
        Product::destroy($product);

        ProductDeleted::dispatch($product);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
