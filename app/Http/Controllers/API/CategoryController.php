<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{

    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }


    public function index()
    {
        $categories = $this->categoryRepository->paginate(10);
        return CategoryResource::collection($categories);
    }

    public function show($id)
    {
        $category = $this->categoryRepository->findOrFail($id);
        return new CategoryResource($category);
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->categoryRepository->create($request->validated());
        return (new CategoryResource($category))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->findOrFail($id);
        $category = $this->categoryRepository->update($category, $request->validated());
        return (new CategoryResource($category))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $category = $this->categoryRepository->findOrFail($id);
        $this->categoryRepository->delete($category);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
