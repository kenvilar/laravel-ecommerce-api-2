<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Buyers*/
Route::resource('buyers', 'Buyer\BuyersController', ['only' => ['index', 'show',]]);
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index',]]);
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index',]]);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index',]]);
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index',]]);

/*Category*/
Route::resource('categories', 'Category\CategoriesController', ['except' => ['create', 'edit',]]);
Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index',]]);
Route::resource('categories.sellers', 'Category\CategorySellerController', ['only' => ['index',]]);
Route::resource('categories.transactions', 'Category\CategoryTransactionController', ['only' => ['index',]]);
Route::resource('categories.buyers', 'Category\CategoryBuyerController', ['only' => ['index',]]);

/*Products*/
Route::resource('products', 'Product\ProductsController', ['only' => ['index', 'show',]]);
Route::resource('products.transactions', 'Product\ProductTransactionController', ['only' => ['index',]]);
Route::resource('products.buyers', 'Product\ProductBuyerController', ['only' => ['index',]]);
Route::resource('products.categories', 'Product\ProductCategoryController', ['only' => ['index', 'update', 'destroy',]]);
Route::resource('products.buyers.transactions', 'Product\ProductBuyerTransactionController', ['only' => ['index',]]);

/*Sellers*/
Route::resource('sellers', 'Seller\SellersController', ['only' => ['index', 'show',]]);
Route::resource('sellers.transactions', 'Seller\SellerTransactionController', ['only' => ['index',]]);
Route::resource('sellers.categories', 'Seller\SellerCategoryController', ['only' => ['index',]]);
Route::resource('sellers.buyers', 'Seller\SellerBuyerController', ['only' => ['index',]]);
Route::resource('sellers.products', 'Seller\SellerProductController', ['only' => ['index', 'store', 'update', 'destroy',]]);

/*Transactions*/
Route::resource('transactions', 'Transaction\TransactionsController', ['only' => ['index', 'show',]]);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index',]]);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index',]]);

/*Users*/
Route::resource('users', 'User\UsersController', ['except' => ['create', 'edit']]);
Route::name('verify')->get('users/verify/{token}', 'User\UsersController@verify');
