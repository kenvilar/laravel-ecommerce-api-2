<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @param Transaction $transaction
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'stock' => (string)$transaction->quantity,
            'buyer' => (int)$transaction->buyer_id,
            'product' => (int)$transaction->product_id,
            'creationDate' => (string)$transaction->created_at,
            'lastChange' => (string)$transaction->updated_at,
            'deletedDate' => isset($transaction->deleted_at) ? (string)$transaction->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transactions.show', $transaction->id),
                ],
                [
                    'rel' => 'transactions.categories',
                    'href' => route('transactions.categories.index', $transaction->id),
                ],
                [
                    'rel' => 'transactions.sellers',
                    'href' => route('transactions.sellers.index', $transaction->id),
                ],
                [
                    'rel' => 'buyers',
                    'href' => route('buyers.show', $transaction->buyer_id),
                ],
                [
                    'rel' => 'products',
                    'href' => route('products.show', $transaction->product_id),
                ],
            ],
        ];
    }

    public static function originalAttributes($index)
    {
        $attributes = [
            'identifier' => 'id',
            'quantity' => 'quantity',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    //this will hide the attribute for example in the api errors
    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identifier',
            'quantity' => 'quantity',
            'buyer_id' => 'buyer',
            'product_id' => 'product',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
