<?php

Route::group(
    [
        'prefix'     => '/',
        'middleware' => ['web'],
        'namespace' => 'Frontend',
    ],
    function () {
        //------------------------------------------------
        Route::get( '/login', 'AuthController@login' )
        ->name( 'login' );
        //------------------------------------------------
        Route::get( '/signout', 'AuthController@signout' )
        ->name( 'vh.frontend.vaahtheme.signout' );
        //------------------------------------------------
        Route::get( '/signin', 'AuthController@signin' )
        ->name( 'vh.frontend.vaahtheme.signin' );
        //------------------------------------------------
        Route::post( '/signin/post', 'AuthController@signinPost' )
        ->name( 'vh.frontend.vaahtheme.signin.post' );
        //------------------------------------------------
        Route::post( '/signin/send/otp', 'AuthController@sendOtp' )
        ->name( 'vh.frontend.vaahtheme.signin.send.otp' );
        //------------------------------------------------
        Route::post( '/signin/send/reset/code', 'AuthController@sendResetCode' )
        ->name( 'vh.frontend.vaahtheme.signin.send.reset.code' );
        //------------------------------------------------
        Route::post( '/signin/password/reset', 'AuthController@passwordResetAndSignin' )
        ->name( 'vh.frontend.vaahtheme.signin.password.reset' );
        //------------------------------------------------
        Route::get( '/signup', 'AuthController@signup' )
        ->name( 'vh.frontend.vaahtheme.signup' );
        //------------------------------------------------
        Route::post( '/signup/post', 'AuthController@signupPost' )
        ->name( 'vh.frontend.vaahtheme.signup.post' );
        //------------------------------------------------
        Route::get( '/signup/activate/{code}', 'AuthController@activate' )
        ->name( 'vh.frontend.vaahtheme.signup.activate' );
        //------------------------------------------------
        Route::any( '/signup/activate/{code}/available', 'AuthController@subDomainAvailable' )
        ->name( 'vh.frontend.vaahtheme.signup.activate.available' );
        //------------------------------------------------
        Route::any( '/signup/activate/{code}/post', 'AuthController@activatePost' )
        ->name( 'vh.frontend.vaahtheme.signup.activate.post' );
        //------------------------------------------------
        //------------------------------------------------
        //------------------------------------------------
    });
