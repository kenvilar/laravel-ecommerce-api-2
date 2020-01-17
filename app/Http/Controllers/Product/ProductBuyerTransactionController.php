<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Transaction;
use App\Transformers\TransactionTransformer;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store',]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param User $buyer
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1',
        ];

        $this->validate($request, $rules);

        if ($buyer->id === $product->seller_id) {
            $this->errorResponse('The buyer must be different from the seller', 409);
        }

        if (!$buyer->isVerified()) {
            return $this->errorResponse('The buyer must be a verified user', 409);
        }

        if (!$product->seller->isVerified()) {
            return $this->errorResponse('The seller must be a verified user', 409);
        }

        if (!$product->isAvailable()) {
            return $this->errorResponse('The product is not available', 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('The product does not have enough units for this transaction', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction, 201);
        });
    }
}
