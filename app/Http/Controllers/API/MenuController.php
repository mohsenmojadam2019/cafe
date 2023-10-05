<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest\ProductStatusRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a paginated list of products with their options.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Product::with('options')->paginate(10);

        return ProductResource::collection($menu);
    }
}

