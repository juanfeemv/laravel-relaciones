<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Category;


class CategoryService
{

    private function findOrFail(int $id): Category
    {
        $category = Category::find($id);

        if (! $category) {
            throw new NotFoundException("Categoría no encontrada: {$id}");
        }

        return $category;
    }

    public function store($data): Category{
        $category = Category::create($data);
        return $category;
    }

    public function update($data, $id): Category{
        $category = $this->findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function destroyById(int $id)
    {
        $category = $this->findOrFail($id);
        if ($category->posts()->exists()) {
            throw new \DomainException('No se puede borrar una categoría con posts asociados.');
        }
        $category->delete();
    }

    public function showById(int $id, bool $withPosts = true): Category
    {
        $category = $this->findOrFail($id);
        if ($withPosts) {
            $category->load('posts');
        }
        return $category;
    }
}
