<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function index(Category $category)
    {
        $transactions = $category->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->unique()
            ->values();

        return $this->showAll($transactions);
    }
}