<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index']]);

Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.products', 'Category\CategoryProductController', ['except' => ['create', 'edit']]);
Route::resource('categories.sellers', 'Category\CategorySellerController', ['except' => ['create', 'edit']]);
Route::resource('categories.transactions', 'Category\CategoryTransactionController', ['only' => ['index']]);
Route::resource('categories.buyers', 'Category\CategoryBuyerController', ['only' => ['index']]);

Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('products', 'Product\ProductController', ['except' => ['create', 'edit']]);

Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index', 'show']]);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index', 'show']]);

Route::resource('notifications', 'NotificationC\NotificationController');
Route::resource('images', 'Image\ImageController');
Route::post('create-directory', 'Image\ImageController@createDirectory');

Route::name('verify')->get(  'users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get(  'users/{user}/resend', 'User\UserController@resend');

Route::group(['namespace' => 'admin', 'prefix' => 'admin', 'middleware' => 'admin'], function() {
//	Route::resource('folders', "FolderController");
});

