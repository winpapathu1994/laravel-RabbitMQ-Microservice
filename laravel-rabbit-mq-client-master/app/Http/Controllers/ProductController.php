<?php

namespace App\Http\Controllers;

use App\Jobs\ProductLike;
use App\Models\Product;
use App\Models\ProductUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function like(Request $request, $id)
    {
        $res = Http::get('http://docker.for.mac.localhost:8000/api/user');

        $user = $res->json();

        try {
            $item =  ProductUser::create([
                'user_id' => $user['id'],
                'product_id' => $id
            ]);

            ProductLike::dispatch($item->toArray())->onQueue('admin_queue');

            return response([
                'message' => 'success'
            ]);
        } catch (Throwable $e) {
            return response([
                'error' => 'error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
