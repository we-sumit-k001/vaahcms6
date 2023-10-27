<?php


Route::group(
    [
        'prefix' => 'testing/taxonomies',
        'middleware' => ['auth:api'],
        'namespace' => 'Backend',
    ],
    function () {
        //---------------------------------------------------------
        Route::get('/assets', 'TaxonomiesController@getAssets')
        ->name('vh.backend.testing.api.taxonomies.assets');
        //---------------------------------------------------------
        Route::get('/', 'TaxonomiesController@getList')
        ->name('vh.backend.testing.api.taxonomies.list');
        //---------------------------------------------------------
        Route::match(['put', 'patch'], '/', 'TaxonomiesController@updateList')
        ->name('vh.backend.testing.api.taxonomies.list.updates');
        //---------------------------------------------------------
        Route::delete('/', 'TaxonomiesController@deleteList')
        ->name('vh.backend.testing.api.taxonomies.list.delete');
        //---------------------------------------------------------
        Route::post('/', 'TaxonomiesController@createItem')
        ->name('vh.backend.testing.api.taxonomies.create');
        //---------------------------------------------------------
        Route::get('/{id}', 'TaxonomiesController@getItem')
        ->name('vh.backend.testing.api.taxonomies.read');
        //---------------------------------------------------------
        Route::match(['put', 'patch'], '/{id}', 'TaxonomiesController@updateItem')
        ->name('vh.backend.testing.api.taxonomies.update');
        //---------------------------------------------------------
        Route::delete('/{id}', 'TaxonomiesController@deleteItem')
        ->name('vh.backend.testing.api.taxonomies.delete');
        //---------------------------------------------------------
    });
