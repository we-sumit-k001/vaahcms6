<?php

Route::group(
    [
        'prefix' => 'backend/training/practices',
        
        'middleware' => ['web', 'has.backend.access'],
        
        'namespace' => 'Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'PracticesController@getAssets')
        ->name('vh.backend.training.practices.assets');
    /**
     * Get List
     */
    Route::get('/', 'PracticesController@getList')
        ->name('vh.backend.training.practices.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'PracticesController@updateList')
        ->name('vh.backend.training.practices.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'PracticesController@deleteList')
        ->name('vh.backend.training.practices.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', 'PracticesController@fillItem')
        ->name('vh.backend.training.practices.fill');

    /**
     * Create Item
     */
    Route::post('/', 'PracticesController@createItem')
        ->name('vh.backend.training.practices.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'PracticesController@getItem')
        ->name('vh.backend.training.practices.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'PracticesController@updateItem')
        ->name('vh.backend.training.practices.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'PracticesController@deleteItem')
        ->name('vh.backend.training.practices.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'PracticesController@listAction')
        ->name('vh.backend.training.practices.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'PracticesController@itemAction')
        ->name('vh.backend.training.practices.item.action');

    //---------------------------------------------------------

});
