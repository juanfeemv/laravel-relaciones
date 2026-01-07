<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * GET /api/v1/posts
     */
    public function index(Request $request)
    {
        $n = $request->integer('per_page', 10);

        $q = Post::query()->with(['category', 'authorProfile', 'tags']);

        if ($search = $request->query('search')) {
            $q->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->integer('category_id')) {
            $q->where('category_id', $categoryId);
        }

        if ($authorProfileId = $request->integer('author_profile_id')) {
            $q->where('author_profile_id', $authorProfileId);
        }

        $result = $q->orderByDesc('id')->paginate($n);

        return new PostCollection($result);
    }

    public function store(StorePostRequest $request, PostService $service)
    {
        $post = $service->store($request->validated());

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id, PostService $service)
    {
        $post = $service->showById($id);

        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, int $id, PostService $service)
    {
        $post = $service->update($request->validated(), $id);

        return new PostResource($post);
    }

    public function destroy(int $id, PostService $service)
    {
        $service->destroyById($id);

        return response()->noContent();
    }
}
