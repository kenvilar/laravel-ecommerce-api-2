<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::all();

        return $this->showAll($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        $this->validate($request, $rules);

        $newCategory = Category::create($request->all());

        return $this->showOne($newCategory, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->only([
            'name',
            'description',
        ]));

        if ($category->isClean()) {
            return $this->errorResponse('You need to specify any different value to update.', 422);
        }

        $category->save();

        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->showOne($category);
    }
}
