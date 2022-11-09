<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
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

/* ---------------------------- START USER ROUTES ------------------------------ */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   return $request->user();
});

/* Register route */
Route::post('/register', [AuthController::class, 'register']);

/* login route */
Route::post('/login', [AuthController::class, 'login']);

/* Logout */
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
/* ----------------------------END USER ROUTES------------------------------------- */


/* ------------------------------------------------------------------------------- */

/* ----------------------------START SUPPLIERS ROUTE------------------------------ */

/* ------------------------------------------------------------------------------- */
/* add Suppliers */

Route::post('/addsuppliers', [SupplierController::class, 'addSuppliers'])->middleware('auth:sanctum');

/* get all suppliers */
Route::get('/getsuppliers', [SupplierController::class, 'getSuppliers']);

/* get supplier by id */
Route::get('/getsuppliers/{id}', [SupplierController::class, 'suppliersById']);

/* delete supplier by id */
Route::delete('/deletesuppliers/{id}', [SupplierController::class, 'deleteSuppliers'])->middleware('auth:sanctum');

/* update supplier by id */
Route::put('/updatesuppliers/{id}', [SupplierController::class, 'updateSuppliers'])->middleware('auth:sanctum');

/* ----------------------------END SUPPLIERS ROUTE------------------------------ */

/* ------------------------------------------------------------------------------- */

/* ----------------------------START CATEGORIES ROUTE------------------------------ */

/* ------------------------------------------------------------------------------- */
/* add categories */
Route::post('/addcategories', [CategoryController::class, 'addCategories'])->middleware('auth:sanctum');

/* get all categories  */
Route::get('/getcategories', [CategoryController::class, 'getCategories']);

/* get categories by id */
Route::get('/getcategories/{id}', [CategoryController::class, 'categoriesById']);

/* delete categories by id */
Route::delete('/deletecategories/{id}', [CategoryController::class, 'deleteCategories'])->middleware('auth:sanctum');

/* update categories by id */
Route::put('/updatecategories/{id}', [CategoryController::class, 'updateCategories'])->middleware('auth:sanctum');
/* ----------------------------END CATEGORIES ROUTE------------------------------ */

/* ------------------------------------------------------------------------------- */

/* ----------------------------START PRODUCTS ROUTE------------------------------ */
/* add products */
Route::post('/addproducts', [ProductController::class, 'addProducts'])->middleware('auth:sanctum');

/* get all products  */
Route::get('/getproducts', [ProductController::class, 'getProducts']);

/* get products by id */
Route::get('/getproducts/{id}', [ProductController::class, 'productsById']);

/* delete products by id */
Route::delete('/deleteproducts/{id}', [ProductController::class, 'deleteProducts'])->middleware('auth:sanctum');

/* update products by id */
Route::put('/updateproducts/{id}', [ProductController::class, 'updateProducts'])->middleware('auth:sanctum');

/* Search route products */
Route::get('/getproducts/search/product/{response}', [ProductController::class, 'searchProduct']);
/* ----------------------------END PRODUCTS ROUTE------------------------------ */

/* ------------------------------------------------------------------------------- */

/* ----------------------------START POST ROUTE------------------------------ */

/* ------------------------------------------------------------------------------- */
/* add post */
Route::post('/addpost', [PostController::class, 'addPost'])/* ->middleware('auth:sanctum') */;
/* get all posts */
Route::get('/getposts', [PostController::class, 'getPosts']);
/* get posts with id */
Route::get('/getposts/{id}', [PostController::class, 'getPostsById']);
/* delete post */
Route::delete('/deletepost/{id}', [PostController::class, 'deletePost']);
/* update post by id */
Route::put('/updatepost/{id}', [PostController::class, 'updatePost']);

/* ------------------------------------------------------------------------------- */

/* ----------------------------START COMMENTS ROUTES------------------------------ */

/* ------------------------------------------------------------------------------- */

/* add comment, id */
Route::post('/addcomment/{id}', [PostController::class, 'addComment']);
/* get comments, id */
Route::get('/getcomments/{id}', [PostController::class, 'getCommentsByPost']);
/* get all comments*/
Route::get('/getcomments', [PostController::class, 'getComments']);
/* delete comment */
Route::delete('/deletecomment/{id}', [PostController::class, 'deleteComment']);
/* update comment by id */
Route::put('/updatecomment/{id}', [PostController::class, 'updateComment']);

/* ----------------------------END POST/COMMENTS ROUTE------------------------------ */

/* ------------------------------------------------------------------------------- */


/* ----------------------------FALLBACK FUNCTION------------------------------ */
/* ----- If method or route can't be found, this messege will show as feedback -----*/
Route::fallback(function () {
   return response()->json([
      'message' => 'Route or method could not be found, check spelling and try again!'
   ], 404);
});
/* ------------------------------------------------------------------------------- */

