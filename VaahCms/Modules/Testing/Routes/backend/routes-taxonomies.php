<?php

Route::group(
    [
       'prefix' => 'backend/testing/taxonomies',
        
        'middleware' => ['web', 'has.backend.access'],
        
        'namespace' => 'Backend',
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', 'TaxonomiesController@getAssets')
        ->name('vh.backend.testing.taxonomies.assets');
    /**
     * Get List
     */
    Route::get('/', 'TaxonomiesController@getList')
        ->name('vh.backend.testing.taxonomies.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', 'TaxonomiesController@updateList')
        ->name('vh.backend.testing.taxonomies.list.update');
    /**
     * Delete List
     */
    Route::delete('/', 'TaxonomiesController@deleteList')
        ->name('vh.backend.testing.taxonomies.list.delete');


    /**
     * Create Item
     */
    Route::post('/', 'TaxonomiesController@createItem')
        ->name('vh.backend.testing.taxonomies.create');
    /**
     * Get Item
     */
    Route::get('/{id}', 'TaxonomiesController@getItem')
        ->name('vh.backend.testing.taxonomies.read');
    /**
     * Get List by type id
     */
    Route::get('/type/{id}', 'TaxonomiesController@getListByTypeId')
        ->name('vh.backend.testing.taxonomies.type.id');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', 'TaxonomiesController@updateItem')
        ->name('vh.backend.testing.taxonomies.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', 'TaxonomiesController@deleteItem')
        ->name('vh.backend.testing.taxonomies.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', 'TaxonomiesController@listAction')
        ->name('vh.backend.testing.taxonomies.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', 'TaxonomiesController@itemAction')
        ->name('vh.backend.testing.taxonomies.item.action');


    /**
     * Create taxonomy type
     */
    Route::post( '/create-taxonomy-type', 'TaxonomiesController@createTaxonomyType' )
        ->name( 'vh.backend.testing.taxonomies.createTaxonomyType' );

    /**
     * Delete taxonomy type
     */
    Route::post( '/delete-taxonomy-type', 'TaxonomiesController@deleteTaxonomyType' )
        ->name( 'vh.backend.testing.taxonomies.deleteTaxonomyType' );

    /**
     * Update taxonomy type
     */
    Route::post( '/update-taxonomy-type', 'TaxonomiesController@updateTaxonomyType' )
        ->name( 'vh.backend.testing.taxonomies.updateTaxonomyType' );

    /**
     * Update taxonomy type positions
     */
    Route::post( 'update-taxonomy-type-position', 'TaxonomiesController@updateTaxonomyTypePosition' )
        ->name( 'vh.backend.testing.taxonomies.updateTaxonomyTypePosition' );

    /**
     * Get parent
     */
    Route::get('/json/parents/{id}/{name?}', 'TaxonomiesController@getParents' )
        ->name( 'vh.backend.testing.taxonomies.countries' );

    /**
     * Get country by ID
     */
    Route::get( 'json/getCountryById/{id}', 'TaxonomiesController@getCountryById' )
        ->name( 'vh.backend.testing.taxonomies.getCountryById' );
    //---------------------------------------------------------

});
