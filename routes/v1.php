<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ParseJWTToken;

Route::group([
    'prefix' => '{locale}', 
    'where' => ['locale' => '[a-zA-Z]{2}'], 
    'middleware' => 'setlocale'], function() {

        Route::group(['prefix' => 'super-admin', 'as' => 'super-admin.'], function() {

            Route::post('/sign-in', \App\Mrt\SuperAdmin\Actions\SignInAction::class);

            Route::middleware([ParseJWTToken::class])->group(function () {

                Route::group(['prefix' => 'branch', 'as' => 'branch.'], function() {

                    Route::get('/', \App\Mrt\Branch\Actions\ListAction::class);

                    Route::post('/', \App\Mrt\Branch\Actions\AddAction::class)->name('create');

                    Route::group(['prefix' => '/{branch_id}', 'where' => ['branch_id' => '[0-9]+']], function() {

                        Route::get('', \App\Mrt\Branch\Actions\AboutAction::class)->name('view');

                        Route::put('', \App\Mrt\Branch\Actions\SaveAction::class)->name('update');

                        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {

                            Route::get('/', \App\Mrt\Admin\Actions\ListAction::class);

                            Route::post('/', \App\Mrt\Admin\Actions\AddAction::class)->name('create');

                            Route::group(['prefix' => '/{admin_id}', 'where' => ['admin_id' => '[0-9]+']], function() {

                                Route::put('', \App\Mrt\Admin\Actions\SaveAction::class)->name('update');

                            });

                        });

                    });

                });

            });

        });

        Route::group(['prefix' => 'branch-admin', 'as' => 'branch-admin.'], function() {

            Route::post('/sign-in', \App\Mrt\Admin\Actions\SignInAction::class);

            Route::middleware([ParseJWTToken::class])->group(function () {

                Route::group(['prefix' => 'reception', 'as' => 'reception.'], function() {

                    Route::get('/', \App\Mrt\Reception\Actions\ListAction::class);

                    Route::post('/', \App\Mrt\Reception\Actions\AddAction::class)->name('create');

                    Route::group(['prefix' => '/{reception_id}', 'where' => ['reception_id' => '[0-9]+']], function() {

                        Route::put('', \App\Mrt\Reception\Actions\SaveAction::class)->name('update');

                    });

                });

                Route::group(['prefix' => 'assistant', 'as' => 'assistant.'], function() {

                    Route::get('/', \App\Mrt\Assistant\Actions\ListAction::class);

                    Route::post('/', \App\Mrt\Assistant\Actions\AddAction::class)->name('create');

                    Route::group(['prefix' => '/{assistant_id}', 'where' => ['assistant_id' => '[0-9]+']], function() {

                        Route::put('', \App\Mrt\Assistant\Actions\SaveAction::class)->name('update');

                    });

                });

                Route::group(['prefix' => 'doctor', 'as' => 'doctor.'], function() {

                    Route::get('/', \App\Mrt\Doctor\Actions\ListAction::class);

                    Route::post('/', \App\Mrt\Doctor\Actions\AddAction::class)->name('create');

                    Route::group(['prefix' => '/{doctor_id}', 'where' => ['doctor_id' => '[0-9]+']], function() {

                        Route::get('', \App\Mrt\Doctor\Actions\AboutAction::class)->name('view');

                        Route::put('', \App\Mrt\Doctor\Actions\SaveAction::class)->name('update');

                    });

                });

            });

        });

        Route::group(['prefix' => 'patient', 'as' => 'patient.'], function() {

            Route::post('/sign-in', \App\Mrt\Patient\Actions\SignInAction::class);

            Route::middleware([ParseJWTToken::class])->group(function () {

            });

        });

        Route::group(['prefix' => 'doctor', 'as' => 'doctor.'], function() {

            Route::post('/sign-in', \App\Mrt\Doctor\Actions\SignInAction::class);

            Route::middleware([ParseJWTToken::class])->group(function () {

            });

        });

        Route::group(['prefix' => 'reference'], function() {

            Route::get('/punkt', \App\Mrt\Punkt\Actions\ListAction::class);

        });

    });