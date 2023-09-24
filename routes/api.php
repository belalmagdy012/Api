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



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace'=>'Api'
], function ($router) {
    Route::post('/login', 'AuthController@login');
    Route::post('/register','AuthController@register');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/user-profile', 'AuthController@userProfile');
});






Route::group(['middleware' => ['checkPassword'] , 'namespace'=>'Api'], function() {

    Route::get('category', 'CtegoryController@index');
    Route::get('category/{id}', 'CtegoryController@show');
    Route::post('category', 'CtegoryController@store');
    Route::post('category/{id}', 'CtegoryController@update');
    Route::post('category_delet/{id}', 'CtegoryController@destroy');


});


////////////////////// Ahmed Emam Api //////////////////
/////// Alll api here must be authentcated


///////////////////////// Route For Admin ///////////////////////////
Route::group(['middleware'=>['api','checkPassword','changeLanguage','checkAdminToken:admin_api'],'namespace'=>'Api'], function () {
    Route::post('get_all_category', 'CtegoryController@index');
    Route::post('get_category_byId', 'CtegoryController@getCategoryById');
    Route::post('change_category_status', 'CtegoryController@changeStatus');


  });




Route::group(['middleware'=>['api','checkPassword','changeLanguage'],'namespace'=>'Api'], function () {
        Route::post('get_all_category', 'CtegoryController@index');
        Route::post('get_category_byId', 'CtegoryController@getCategoryById');
        Route::post('change_category_status', 'CtegoryController@changeStatus');

        Route::group(['prefix' => 'admin','namespace'=>'Admin'],function (){
            Route::post('login', 'AuthControlleer@login');
            Route::post('logout','AuthControlleer@logout') -> middleware(['auth.guard:admin_api']);
              //invalidate token security side
             //broken access controller user enumeration
        });

        Route::group(['prefix' => 'user','namespace'=>'User'],function (){
            Route::post('login','AuthControlleer@Login') ;
        });


        Route::group(['prefix' => 'user' ,'middleware' => 'auth.guard:user_api'],function (){
            Route::post('profile',function(){
                return  \Auth::user(); // return authenticated user data
                //return 'user can retch me ';
            });
        });





      });




