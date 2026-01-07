<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\StoreTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * GET /api/v1/tags
     */
    public function index(Request $request)
    {
        $n = $request->integer('per_page', 10);

        $q = Tag::query();

        if ($search = $request->query('search')) {
            $q->where('name', 'like', "%{$search}%");
        }

        // opcional: traer número de posts asociados
        // $q->withCount('posts');

        $result = $q->orderBy('name')->paginate($n);

        return new TagCollection($result);
    }

    public function store(StoreTagRequest $request, TagService $service)
    {
        $tag = $service->store($request->validated());

        return (new TagResource($tag))
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id, TagService $service)
    {
        $tag = $service->showById($id);

        return new TagResource($tag);
    }

    public function update(UpdateTagRequest $request, int $id, TagService $service)
    {
        $tag = $service->update($request->validated(), $id);

        return new TagResource($tag);
    }

    public function destroy(int $id, TagService $service)
    {
        $service->destroyById($id);

        return response()->noContent();
    }
}
