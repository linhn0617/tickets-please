<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\AuthorTicketsController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// http:localhost:8000/api
// universal resource locator
// tickets
// users
// contracts

/*  Route model Binding  官方文件： https://laravel.com/docs/11.x/routing#route-model-binding 以及 https://laravel.com/docs/11.x/routing#customizing-the-key
    Route會預設使用id進行查詢，如果想要透過某個特定欄位進行查詢時，有以下方法：
    1.在model中進行複寫 :
    public function getRouteKeyName()
    {
        return 'slug'; slug即為欄位名稱
    } 
    2.在route中定義：
    Route::get('/posts/{post:slug}', function (Post $post) {
        return $post;
    }); 
*/
Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('tickets', TicketController::class)->except(['update']);
    Route::put('tickets/{ticket}', [TicketController::class, 'replace']);
    Route::patch('tickets/{ticket}', [TicketController::class, 'update']);

    Route::apiResource('authors', AuthorsController::class);
    Route::apiResource('authors.tickets', AuthorTicketsController::class)->except(['update']);
    Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'replace']);
    Route::patch('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'update']);


    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


