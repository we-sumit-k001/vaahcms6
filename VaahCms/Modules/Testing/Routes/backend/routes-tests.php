<?php

Route::group(
    [
        'prefix' => 'backend/testing/tests',

        'middleware' => ['web', 'has.backend.access'],

        'namespace' => 'Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'TestsController@getAssets')
        ->name('vh.backend.testing.tests.assets');
    /**
     * Get List
     */
    Route::get('/', 'TestsController@getList')
        ->name('vh.backend.testing.tests.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'TestsController@updateList')
        ->name('vh.backend.testing.tests.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'TestsController@deleteList')
        ->name('vh.backend.testing.tests.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', 'TestsController@fillItem')
        ->name('vh.backend.testing.tests.fill');

    /**
     * Create Item
     */
    Route::post('/', 'TestsController@createItem')
        ->name('vh.backend.testing.tests.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'TestsController@getItem')
        ->name('vh.backend.testing.tests.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'TestsController@updateItem')
        ->name('vh.backend.testing.tests.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'TestsController@deleteItem')
        ->name('vh.backend.testing.tests.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'TestsController@listAction')
        ->name('vh.backend.testing.tests.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'TestsController@itemAction')
        ->name('vh.backend.testing.tests.item.action');

    //---------------------------------------------------------


    Route::post('/notify', 'TestsController@notify')
        ->name('vh.backend.testing.tests.notify');

    Route::get('/state/{id}', 'TestsController@State')
        ->name('vh.backend.testing.tests.item.state');

    Route::get('/state-filter/{slug}', 'TestsController@stateFilter')
        ->name('vh.backend.testing.tests.item.stateFilter');

    Route::get('/item/{id}/practice', 'TestsController@getItemPractice')
        ->name('vh.backend.testing.item.practices');

    Route::post('/actions/{action_name}', 'TestsController@postActions')
        ->name('backend.vaah.testing.actions');

});
