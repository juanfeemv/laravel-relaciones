<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profiles\StoreProfileRequest;
use App\Http\Requests\Profiles\UpdateProfileRequest;
use App\Http\Resources\ProfileCollection;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * GET /api/v1/profiles
     */
    public function index(Request $request)
    {
        $n = $request->integer('per_page', 10);

        $q = Profile::query()->with('user');

        if ($search = $request->query('search')) {
            $q->where('bio', 'like', "%{$search}%")
              ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
        }

        $result = $q->orderByDesc('id')->paginate($n);

        return new ProfileCollection($result);
    }

    public function store(StoreProfileRequest $request, ProfileService $service)
    {
        $profile = $service->store($request->validated());

        return (new ProfileResource($profile))
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id, ProfileService $service)
    {
        $profile = $service->showById($id);

        return new ProfileResource($profile);
    }

    public function update(UpdateProfileRequest $request, int $id, ProfileService $service)
    {
        $profile = $service->update($request->validated(), $id);

        return new ProfileResource($profile);
    }

    public function destroy(int $id, ProfileService $service)
    {
        $service->destroyById($id);

        return response()->noContent();
    }
}
