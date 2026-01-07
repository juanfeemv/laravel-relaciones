<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Post;

class PostService
{
    private function findOrFail(int $id): Post
    {
        $post = Post::find($id);

        if (! $post) {
            throw new NotFoundException("Post no encontrado: {$id}");
        }

        return $post;
    }

    public function store(array $data): Post
    {
        $tagIds = $data['tag_ids'] ?? null;
        unset($data['tag_ids']);

        $post = Post::create($data);

        if (is_array($tagIds)) {
            $post->tags()->sync($tagIds);
        }

        return $post->load(['category', 'authorProfile', 'tags']);
    }

    public function update(array $data, int $id): Post
    {
        $post = $this->findOrFail($id);

        $tagIds = $data['tag_ids'] ?? null;
        unset($data['tag_ids']);

        $post->update($data);

        if (is_array($tagIds)) {
            $post->tags()->sync($tagIds);
        }

        return $post->load(['category', 'authorProfile', 'tags']);
    }

    public function destroyById(int $id): void
    {
        $post = $this->findOrFail($id);
        $post->tags()->detach(); // limpio pivot
        $post->delete();
    }

    public function showById(int $id): Post
    {
        return $this->findOrFail($id)->load(['category', 'authorProfile', 'tags']);
    }
}
