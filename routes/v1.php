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

        Route::group(['prefix' => 'department', 'as' => 'department.'], function() {

            Route::post('/ecp-auth', \App\Edus\Departments\Actions\EcpAuthAction::class);

            Route::middleware([ParseJWTToken::class])->group(function () {

                Route::group(['prefix' => 'commision'], function() {

                    Route::get('/', \App\Edus\Commissions\Actions\ListAction::class);

                    Route::post('/', \App\Edus\Commissions\Actions\AddAction::class);

                    Route::put('/{id}', \App\Edus\Commissions\Actions\EditAction::class)->whereNumber('id');

                });

                Route::group(['prefix' => 'place', 'as'=>'place.'], function() {

                    Route::get('/', \App\Edus\Place\Actions\ListAction::class);

                    Route::post('/', \App\Edus\Place\Actions\AddAction::class);

                    Route::group(['prefix' => '/{place_id}', 'where' => ['place_id' => '[0-9]+']], function() {

                        Route::get('', \App\Edus\Place\Actions\AboutAction::class);

                        Route::put('', \App\Edus\Place\Actions\EditAction::class)->name('update');

                        Route::delete('', \App\Edus\Place\Actions\DeleteAction::class)->name('delete');

                        Route::put('/publish', \App\Edus\Place\Actions\PublishAction::class)->name('publish');

                    });

                });

                Route::group(['prefix' => 'organization', 'as'=>'organization.'], function() {

                    Route::get('/', \App\Edus\Organization\Actions\ListAction::class);

                    Route::group(['prefix' => '/{organization_id}', 'where' => ['organization_id' => '[0-9]+']], function() {

                        Route::get('', \App\Edus\Organization\Actions\AboutAction::class);

                        Route::get('/file/{file_type_id}', \App\Edus\Organization\Actions\FilesListAction::class)->whereNumber('file_type_id');

                        Route::put('/accept', \App\Edus\Organization\Actions\AcceptAction::class)->name('accept');

                        Route::put('/reject', \App\Edus\Organization\Actions\RejectAction::class)->name('reject');

                    });

                });

            });

        });

        Route::group(['prefix' => 'reference'], function() {

            Route::get('/club-category', \App\Edus\ClubCategory\Actions\ListAction::class);

            Route::get('/club-subcategory/{id}', \App\Edus\ClubSubcategory\Actions\ListAction::class)->whereNumber('id');

            Route::get('/commission-type', \App\Edus\CommissionType\Actions\ListAction::class);

            Route::get('/place-status', \App\Edus\PlaceStatus\Actions\ListAction::class);

            Route::get('/place-type', \App\Edus\PlaceType\Actions\ListAction::class);

            Route::get('/punkt', \App\Edus\Punkt\Actions\ListAction::class);

            Route::get('/education-organization-file-type', \App\Edus\EducationOrganizationFileType\Actions\ListAction::class);

            Route::get('/ownership-type', \App\Edus\OwnershipType\Actions\ListAction::class);

            Route::get('/departmental-affiliation', \App\Edus\DepartmentalAffiliation\Actions\ListAction::class);

            Route::get('/legal-form', \App\Edus\LegalForm\Actions\ListAction::class);

            Route::get('/territorial-affiliation', \App\Edus\TerritorialAffiliation\Actions\ListAction::class);

            Route::get('/locality-part', \App\Edus\LocalityPart\Actions\ListAction::class);

            Route::get('/education-type', \App\Edus\EducationType\Actions\ListAction::class);

            Route::get('/org-direction', \App\Edus\OrgDirection\Actions\ListAction::class);

        });

        Route::group(['prefix' => 'organization', 'as' => 'organization.'], function() {

            Route::post('/ecp-auth', \App\Edus\Organization\Actions\EcpAuthAction::class);

            Route::middleware([ParseJWTToken::class])->group(function () {

                Route::group(['prefix' => 'my', 'as' => 'my.'], function() {

                    Route::get('/', \App\Edus\Organization\Actions\ProfileAction::class);

                    Route::put('/save', \App\Edus\Organization\Actions\SaveAction::class)->name('save');

                    Route::put('/check', \App\Edus\Organization\Actions\ToCheckAction::class)->name('to_check');

                    Route::get('/file/{file_type_id}', \App\Edus\Organization\Actions\FilesListAction::class)->whereNumber('file_type_id');

                    Route::post('/file/{file_type_id}', \App\Edus\Organization\Actions\AddFileAction::class)->whereNumber('file_type_id');

                    Route::delete('/file/{file_type_id}/{file_id}', \App\Edus\Organization\Actions\DeleteFileAction::class)->whereNumber('file_type_id')->whereNumber('file_id');

                });

                Route::group(['prefix' => 'place', 'as' => 'place.'], function() {

                    Route::get('/', \App\Edus\Place\Actions\ListForOrgAction::class);

                    Route::group(['prefix' => '/{place_id}', 'where' => ['place_id' => '[0-9]+']], function() {

                        Route::get('', \App\Edus\Place\Actions\AboutForOrgAction::class); //TODO:

                    });

                });

            });

        });

        Route::group(['prefix' => 'file', 'as' => 'file.'], function() {

            Route::post('/upload', \App\Edus\Upload\Actions\UploadAction::class);

            Route::delete('/delete/{id}/{uuid}', \App\Edus\Upload\Actions\DeleteAction::class)->where('id', '[0-9]+');

        });

    });