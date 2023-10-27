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
        'prefix'     => 'backend/testing',
        'middleware' => ['web', 'has.backend.access'],
        'namespace' => 'Backend',
    ],
    function () {
        //------------------------------------------------
        Route::get( '/', 'BackendController@index' )
            ->name( 'vh.backend.testing' );
        //------------------------------------------------
        //------------------------------------------------
        Route::get( '/assets', 'BackendController@getAssets' )
            ->name( 'vh.backend.testing.assets' );
        //------------------------------------------------
    });


/*
 * Include CRUD Routes
 */
//include("backend/routes-example.php");

include ("backend/routes-tests.php");

include ("backend/routes-users.php");

include ("backend/routes-taxonomies.php");
