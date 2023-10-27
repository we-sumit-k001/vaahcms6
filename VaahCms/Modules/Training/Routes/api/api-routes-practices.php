<?php

/*
 * API url will be: <base-url>/public/api/training/practices
 */
Route::group(
    [
        'prefix' => 'training/practices',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', 'PracticesController@getAssets')
        ->name('vh.backend.training.api.practices.assets');
    /**
     * Get List
     */
    Route::get('/', 'PracticesController@getList')
        ->name('vh.backend.training.api.practices.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'PracticesController@updateList')
        ->name('vh.backend.training.api.practices.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'PracticesController@deleteList')
        ->name('vh.backend.training.api.practices.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'PracticesController@createItem')
        ->name('vh.backend.training.api.practices.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'PracticesController@getItem')
        ->name('vh.backend.training.api.practices.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'PracticesController@updateItem')
        ->name('vh.backend.training.api.practices.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'PracticesController@deleteItem')
        ->name('vh.backend.training.api.practices.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'PracticesController@listAction')
        ->name('vh.backend.training.api.practices.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'PracticesController@itemAction')
        ->name('vh.backend.training.api.practices.item.action');



});
