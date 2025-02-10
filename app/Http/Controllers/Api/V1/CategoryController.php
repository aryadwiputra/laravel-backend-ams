<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import ModelNotFoundException
use Exception;

class CategoryController extends Controller
{
    use ApiResponse;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        if (count($categories) == 0) {
            return $this->notFound("Category not found");
        }
        return $this->success($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated(); // Laravel akan otomatis melempar exception jika validasi gagal

        $category = $this->categoryService->createCategory($validated);
        return $this->created($category, 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $category = $this->categoryService->getCategory($id);

        if(!$category) {
            return $this->notFound('Category not found');
        }

        return $this->success($category,'Category found successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $category = $this->categoryService->getCategory($id);

        if(!$category) {
            return $this->notFound('Category not found');
        }

        $validated = $request->validated(); // Laravel akan otomatis melempar exception jika validasi gagal

        $category = $this->categoryService->updateCategory($category, $validated);
        

        return $this->success($category, 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {

            $category = $this->categoryService->getCategory($id);

            if(!$category) {
                return $this->notFound('Category not found');
            }

            $this->categoryService->deleteCategory($category);
            return $this->success(null, 'Category deleted successfully');
        } catch (Exception $e) {
            // Tangani exception jika terjadi kesalahan saat menghapus category
            return $this->error('Failed to delete category: ' . $e->getMessage(), 500);
        }
    }
}