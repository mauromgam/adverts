<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /** @var CategoryRepository $categoryRepository */
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->getAllPaginated($request);

        return $this->sendResponse($categories, 'Categories returned successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate(Category::$rules);

        $category = Category::create($request->all());

        if (!$category) {
            return $this->sendError('Category not created.', 400, $category);
        }

        return $this->sendResponse($category, 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findWithoutFail($id);

        if (!$category) {
            return $this->sendError('Category not found.', 404);
        }

        return $this->sendResponse($category->toDetailsArray(), 'Category returned successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate(Category::$rules);

        /** @var Category $category */
        $category = $this->categoryRepository->findWithoutFail($id);

        if (!$category) {
            return $this->sendError('Category not found.', 404);
        }

        $category->update($request->all());

        return $this->sendResponse($category, 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findWithoutFail($id);

        if (!$category) {
            return $this->sendError('Category not found.', 404);
        }

        $category->delete();

        return $this->sendResponse($category, 'Category updated successfully.');
    }
}
