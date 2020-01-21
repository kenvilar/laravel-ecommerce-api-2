<?php

namespace App\Policies;

use App\Models\Seller;
use App\Traits\AdminActions;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * Determine whether the user can view any sellers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the seller.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Seller  $seller
     * @return mixed
     */
    public function view(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can sale product.
     *
     * @param \App\User $user
     * @param User $seller
     * @return mixed
     */
    public function sale(User $user, User $seller)
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Seller  $seller
     * @return mixed
     */
    public function editProduct(User $user, Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can delete the seller.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Seller  $seller
     * @return mixed
     */
    public function deleteProduct(User $user, Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can delete a product.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Seller  $seller
     * @return mixed
     */
    public function restore(User $user, Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the seller.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Seller  $seller
     * @return mixed
     */
    public function forceDelete(User $user, Seller $seller)
    {
        //
    }
}
