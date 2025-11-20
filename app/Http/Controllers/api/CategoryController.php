<?php

namespace App\Http\Controllers\api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/category
     */
    public function index(Request $request)
    {

        //solo lista de categorias
        //$result = Category::all();
        //$result = Category::with('posts')->get();
        //lista de categorias y posts asociados
        $n = $request->integer('per_page', 10);
        $q = Category::query()->with('posts');
        if ($search = $request->query('search')) {
            $q->where('name', 'like', "%{$search}%");
        }
        $result = $q->orderBy('name')->paginate($n);
        Log::info(json_encode($result));
        //$result = $q->get();

        return response()->json(new CategoryCollection($result), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request, CategoryService $service)
    {
        $v = $request->validated();
        $category = $service->store($v);
        return response()->json(new CategoryResource($category), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, CategoryService $service)
    {
        $category = $service->showById($id);
        return response()->json(new CategoryResource($category), 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, int $id, CategoryService $service)
    {
        $v = $request->validated();
        $category=$service->update($v, $id);
        return response()->json(new CategoryResource($category), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, CategoryService $service)
    {
        $service->destroyById($id);
        return response()->noContent(204);
    }
}
