<?php

Route::group(
    [
        'prefix' => 'backend/testing/users',

                'middleware' => ['web', 'has.backend.access'],

                'namespace' => 'Backend',
    ],
    function () {
        /**
         * Get Assets
         */
        Route::get('/assets', 'UsersController@getAssets')
            ->name('vh.backend.testing.users.assets');
        /**
         * Get List
         */
        Route::get('/', 'UsersController@getList')
            ->name('vh.backend.testing.users.list');
        /**
         * Update List
         */
        Route::match(['put', 'patch'], '/', 'UsersController@updateList')
            ->name('vh.backend.testing.users.list.update');
        /**
         * Delete List
         */
        Route::delete('/', 'UsersController@deleteList')
            ->name('vh.backend.testing.users.list.delete');


        /**
         * Create Item
         */
        Route::post('/', 'UsersController@createItem')
            ->name('vh.backend.testing.users.create');
        /**
         * Get Item
         */
        Route::get('/{id}', 'UsersController@getItem')
            ->name('vh.backend.testing.users.read');
        /**
         * Update Item
         */
        Route::match(['put', 'patch'], '/{id}', 'UsersController@updateItem')
            ->name('vh.backend.testing.users.update');
        /**
         * Delete Item
         */
        Route::delete('/{id}', 'UsersController@deleteItem')
            ->name('vh.backend.testing.users.delete');

        /**
         * List Actions
         */
        Route::any('/action/{action}', 'UsersController@listAction')
            ->name('vh.backend.testing.users.list.actions');

        /**
         * Item actions
         */
        Route::any('/{id}/action/{action}', 'UsersController@itemAction')
            ->name('vh.backend.testing.users.item.action');

        //---------------------------------------------------------

        //---------------------------------------------------------
        Route::get('/item/{id}/roles', 'UsersController@getItemRoles')
            ->name('vh.backend.testing.users.role');

        Route::post('/actions/{action_name}', 'UsersController@postActions')
            ->name('vh.backend.testing.users.actions');
        //---------------------------------------------------------
        Route::post('/avatar/store', 'UsersController@storeAvatar')
            ->name('vh.backend.testing.users.avatar.store');
        //---------------------------------------------------------
        Route::post('/avatar/remove', 'UsersController@removeAvatar')
            ->name('vh.backend.testing.users.avatar.remove');
        //---------------------------------------------------------

        Route::get('/send/notification/{id}', 'UsersController@notify')
            ->name('vh.backend.testing.users.notify');
    });
