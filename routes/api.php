<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Version 1 of the API
Route::prefix('v1')->group(function () {

    // GET routes
    Route::get('/products', [ProductController::class, 'indexV1']);
    Route::get('/products/{product}', [ProductController::class, 'showProductV1']);
    Route::get('/products/{product}/{variant}', [ProductController::class, 'showProductVariantV1']);

    // POST routes
    Route::post('/products', [ProductController::class, 'storeProductV1']);
    
    // PUT/PATCH routes
    //Route::put('/products/{product}', [ProductController::class, 'updateProductV1']);
    //Route::patch('/products/{product}', [ProductController::class, 'updateProductV1']); 
    
    // DELETE routes
    Route::delete('/products/{id}', [ProductController::class, 'deleteProductV1']);
    
    /*  
    Route::put('/tasks/{task}', [TaskController::class, 'updateV1']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroyV1']);
    */  
    });
    