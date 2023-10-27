<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix'     => 'backend/training',
        'middleware' => ['web', 'has.backend.access'],
        'namespace' => 'Backend',
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'BackendController@index' )
            ->name( 'vh.backend.training' );
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/assets', 'BackendController@getAssets' )
            ->name( 'vh.backend.training.assets' );
        //------------------------------------------------
    });


/*
 * Include CRUD Routes
 */
//include("backend/routes-example.php");

include ("backend/routes-practices.php");
