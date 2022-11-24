<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\http\controller\ReactionController;
use App\http\controller\CommentController;
use App\http\controllers\NewPasswordController;
use App\http\controllers\IntrtactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Auth;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);


Route::group(['middleware'=>['auth:sanctum']],
    function (){
        Route::get('/logout',[UserController::class,'logout']);
        Route::prefix('/post')->group(
            function (){
                Route::get('/home',[PostController::class,'index']);
                Route::post('comment/{id}', 'App\Http\Controllers\CommentController@store');
                Route::get('/comment/{id}', 'App\Http\Controllers\CommentController@getComments');
                Route::post('/reaction/{id}', 'App\Http\Controllers\ReactionController@store');
                Route::post('/add',[PostController::class,'store']);
                Route::get('/profile',[PostController::class,'profile']);
                Route::delete('/{id}',[PostController::class,'destroy']);
                Route::post('/{id}',[PostController::class,'update']);
                Route::post('/like/{id}',[IntrtactionController::class,'like']);
                Route::get('/{id}/likes',[PostController::class,'likes']);
            }
        );
        Route::prefix('/comment')->group(
            function (){
                Route::delete('/{id}', 'App\Http\Controllers\CommentController@delete');
                Route::post('/{id}', 'App\Http\Controllers\CommentController@update');
            }
        );
    }
    
);


Route::get('/index',[UserController::class,'index']);
Route::post('/search',[UserController::class,'search']);


