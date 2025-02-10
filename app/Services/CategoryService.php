<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\HandleImageUpload;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Repositories\Categories\CategoryRepositoryInterface;
use App\Traits\ApiResponse;

class CategoryService
{
    use HandleImageUpload, ApiResponse;

    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategory($category_id)
    {
        $category = $this->categoryRepository->getById($category_id);

        return $category;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function createCategory(array $data)
    {
        try {
            DB::beginTransaction();

            $data['slug'] = $this->categoryRepository->generateUniqueSlug($data['name']);

            // Handle image upload
            if (isset($data['image'])) {
                $path = 'categories'; // Tentukan path penyimpanan
                $data['image'] = $this->uploadImage($data['image'], $path);
            }

            $category = $this->categoryRepository->create($data);

            DB::commit();

            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            // Log error atau lakukan tindakan lain
            throw new Exception("Failed to create category: " . $e->getMessage());
        }
    }

    public function updateCategory(Category $category, array $data)
    {
        try {
            DB::beginTransaction();

            $data['slug'] = $this->categoryRepository->generateUniqueSlug($data['name'], $category->id);

            // Handle image update
            if (isset($data['image'])) {
                $path = 'categories';
                $data['image'] = $this->updateImage($data['image'], $category->image, $path);
            }

            $this->categoryRepository->update($category, $data);

            DB::commit();

            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            // Log error atau lakukan tindakan lain
            throw new Exception("Failed to update category: " . $e->getMessage());
        }
    }

    public function deleteCategory(Category $category)
    {
        try {
            DB::beginTransaction();

            // Delete image if exists
            if ($category->image) {
                $this->deleteImage($category->image);
            }

            $this->categoryRepository->delete($category);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            // Log error atau lakukan tindakan lain
            throw new Exception("Failed to delete category: " . $e->getMessage());
        }
    }
}