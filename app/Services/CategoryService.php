<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Category;


class CategoryService
{

    public function store($data): Category{
        $category = Category::create($data);
        return $category;
    }

    public function update($data, $id): Category{
        $category = Category::find($id);
        if (!$category) {
            throw new NotFoundException("Categoría no encontrada: " . $id);
        }
        $category->update($data);
        return $category;
    }

    public function destroyById(int $id)
    {
        $category = Category::find($id);
        if (!$category) {
            throw new NotFoundException("Categoría no encontrada: " . $id);
        }
        $category->delete();
    }

    public function showById(int $id): Category
    {
        $category = Category::find($id);
        if (!$category) {
            throw new NotFoundException("Categoría no encontrada: " . $id);
        }
        $category->load('posts');
        return $category;
    }
}
