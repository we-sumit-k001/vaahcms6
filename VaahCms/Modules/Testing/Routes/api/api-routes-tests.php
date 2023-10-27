<?php

/*
 * API url will be: <base-url>/public/api/testing/tests
 */
Route::group(
    [
        'prefix' => 'testing/tests',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'TestsController@getAssets')
        ->name('vh.backend.testing.api.tests.assets');
    /**
     * Get List
     */
    Route::get('/', 'TestsController@getList')
        ->name('vh.backend.testing.api.tests.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'TestsController@updateList')
        ->name('vh.backend.testing.api.tests.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'TestsController@deleteList')
        ->name('vh.backend.testing.api.tests.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'TestsController@createItem')
        ->name('vh.backend.testing.api.tests.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'TestsController@getItem')
        ->name('vh.backend.testing.api.tests.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'TestsController@updateItem')
        ->name('vh.backend.testing.api.tests.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'TestsController@deleteItem')
        ->name('vh.backend.testing.api.tests.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'TestsController@listAction')
        ->name('vh.backend.testing.api.tests.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'TestsController@itemAction')
        ->name('vh.backend.testing.api.tests.item.action');



});
