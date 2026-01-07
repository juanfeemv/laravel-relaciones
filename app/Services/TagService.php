<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Tag;

class TagService
{
    private function findOrFail(int $id): Tag
    {
        $tag = Tag::find($id);

        if (! $tag) {
            throw new NotFoundException("Tag no encontrado: {$id}");
        }

        return $tag;
    }

    public function store(array $data): Tag
    {
        return Tag::create($data);
    }

    public function update(array $data, int $id): Tag
    {
        $tag = $this->findOrFail($id);
        $tag->update($data);

        return $tag;
    }

    public function showById(int $id): Tag
    {
        return $this->findOrFail($id);
    }

    public function destroyById(int $id): void
    {
        $tag = $this->findOrFail($id);

        // Limpieza del pivot
        $tag->posts()->detach();

        $tag->delete();
    }
}
