<?php
namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Category;


class CategoryService
{
    public function destroyById(int $id)
    {
        $category = Category::find($id);
        if(!$category){
            throw new NotFoundException("Categoría no encontrada: ".$id);
        }
        $category->delete();
    }
}
