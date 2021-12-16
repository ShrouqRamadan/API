<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Authcontroller;


Route::post('register', 'Authcontroller@register');
Route::post('login', 'Authcontroller@login');


//private routes
Route::group(["middleware"=>["auth:sanctum"]],function(){
        Route::resources([
            "products"=>"ProductController"
        ]);
Route::post('logout', 'Authcontroller@logout');

    }
);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
