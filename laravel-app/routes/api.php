<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\ProductController;

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

Route::group(
    [
        'prefix' => 'v1',
        'as' => 'api.',
        'namespace' => 'Api\V1\Admin',
    ],
    function () {
        Route::resource('products', 'ProductController');
        // Route::apiResource('abilities', 'AbilitiesController', ['only' => ['index']]);

        // Route::get('locales/languages', 'LocalesController@languages')->name('locales.languages');
        // Route::get('locales/messages', 'LocalesController@messages')->name('locales.messages');

        // Route::resource('permissions', 'PermissionsApiController');

        // Route::resource('roles', 'RolesApiController');


        // Route::resource('contact-companies', 'ContactCompanyApiController');

        // Route::resource('contact-contacts', 'ContactContactsApiController');
    }
);
