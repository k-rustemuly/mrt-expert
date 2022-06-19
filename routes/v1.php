<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ParseJWTToken;
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
    'prefix' => '{locale}', 
    'where' => ['locale' => '[a-zA-Z]{2}'], 
    'middleware' => 'setlocale'], function() {

        Route::group(['prefix' => 'super-admin', 'as' => 'super-admin.'], function() {

            Route::post('/sign-in', \App\Mrt\SuperAdmin\Actions\SignInAction::class);

            Route::middleware([ParseJWTToken::class])->group(function () {

                Route::group(['prefix' => 'branche'], function() {

                    Route::get('/', \App\Mrt\Branche\Actions\ListAction::class);

                    Route::post('/', \App\Mrt\Branche\Actions\AddAction::class);

                });

            });

        });

        Route::group(['prefix' => 'reference'], function() {

            Route::get('/punkt', \App\Mrt\Punkt\Actions\ListAction::class);

        });

    });