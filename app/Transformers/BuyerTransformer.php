<?php

namespace App\Transformers;

use App\Models\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
     * @param Buyer $buyer
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int)$buyer->id,
            'name' => (string)$buyer->name,
            'email' => (string)$buyer->email,
            'isVerified' => (int)$buyer->verified,
            'creationDate' => (string)$buyer->created_at,
            'lastChange' => (string)$buyer->updated_at,
            'deletedDate' => isset($buyer->deleted_at) ? (string)$buyer->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $buyer->id),
                ],
                [
                    'rel' => 'buyers.categories',
                    'href' => route('buyers.categories.index', $buyer->id),
                ],
                [
                    'rel' => 'buyers.products',
                    'href' => route('buyers.products.index', $buyer->id),
                ],
                [
                    'rel' => 'buyers.sellers',
                    'href' => route('buyers.sellers.index', $buyer->id),
                ],
                [
                    'rel' => 'buyers.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id),
                ],
                [
                    'rel' => 'users',
                    'href' => route('users.show', $buyer->id),
                ],
            ],
        ];
    }

    public static function originalAttributes($index)
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
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
            'name' => 'name',
            'email' => 'email',
            'verified' => 'isVerified',
            'created_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
