<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/* 
|-------------------------------------------------------------------------------
| Auth Routes
|------------------------------------------------------------------------------
*/
$router->group(['namespace' => 'Auth'], function () use ($router) {
    $router->post('register', ['as' => 'auth.register', 'uses' => 'AuthController@register']);
    $router->post('login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
    $router->group(['middleware' => 'auth', 'prefix' => 'auth'], function () use ($router) {
        $router->get('profile', ['as' => 'auth.profile', 'uses' => 'AuthController@profile']);
        $router->get('logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout']);
    });
});


$router->group(['middleware' => 'auth'], function () use ($router) {

    /* 
    |-------------------------------------------------------------------------------
    | Routes for Users
    |------------------------------------------------------------------------------
    */
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/', ['as' => 'users.index', 'uses' => 'UserController@index']);
        $router->post('/', ['as' => 'users.store', 'uses' => 'UserController@store']);
        $router->group(['prefix' => '/{id}'], function () use ($router) {
            $router->get('/', ['as' => 'users.show', 'uses' => 'UserController@show']);
            $router->put('/', ['as' => 'users.update', 'uses' => 'UserController@update']);
            $router->delete('/', ['as' => 'users.delete', 'uses' => 'UserController@destroy']);
        });
    });

    $router->group(['prefix' => 'configuration'], function () use ($router) {
        $router->group(['prefix' => 'localization', 'namespace' => 'Localization'], function () use ($router) {

            /* 
            |-------------------------------------------------------------------------------
            | Routes for Countries
            |------------------------------------------------------------------------------
            */
            $router->group(['prefix' => 'countries'], function () use ($router) {
                $router->get('/', ['as' => 'countries.index', 'uses' => 'CountryController@index']);
                $router->post('/', ['as' => 'countries.store', 'uses' => 'CountryController@store']);
                $router->group(['prefix' => '/{id}'], function () use ($router) {
                    $router->get('/', ['as' => 'countries.show', 'uses' => 'CountryController@show']);
                    $router->put('/', ['as' => 'countries.update', 'uses' => 'CountryController@update']);
                    $router->delete('/', ['as' => 'countries.delete', 'uses' => 'CountryController@destroy']);
                });
            });


            /* 
            |-------------------------------------------------------------------------------
            | Routes for States
            |------------------------------------------------------------------------------
            */
            $router->group(['prefix' => 'states'], function () use ($router) {
                $router->get('/', ['as' => 'states.index', 'uses' => 'StateController@index']);
                $router->post('/', ['as' => 'states.store', 'uses' => 'StateController@store']);
                $router->group(['prefix' => '/{id}'], function () use ($router) {
                    $router->get('/', ['as' => 'states.show', 'uses' => 'StateController@show']);
                    $router->put('/', ['as' => 'states.update', 'uses' => 'StateController@update']);
                    $router->delete('/', ['as' => 'states.delete', 'uses' => 'StateController@destroy']);
                });
            });


            /* 
            |-------------------------------------------------------------------------------
            | Routes for Cities
            |------------------------------------------------------------------------------
            */
            $router->group(['prefix' => 'cities'], function () use ($router) {
                $router->get('/', ['as' => 'cities.index', 'uses' => 'CityController@index']);
                $router->post('/', ['as' => 'cities.store', 'uses' => 'CityController@store']);
                $router->group(['prefix' => '/{id}'], function () use ($router) {
                    $router->get('/', ['as' => 'cities.show', 'uses' => 'CityController@show']);
                    $router->put('/', ['as' => 'cities.update', 'uses' => 'CityController@update']);
                    $router->delete('/', ['as' => 'cities.delete', 'uses' => 'CityController@destroy']);
                });
            });
        });
        $router->group(['namespace' => 'Configuration'], function () use ($router) {


            /* 
            |-------------------------------------------------------------------------------
            | Routes for Room Types
            |------------------------------------------------------------------------------
            */
            $router->group(['prefix' => 'room_types'], function () use ($router) {
                $router->get('/', ['as' => 'room_types.index', 'uses' => 'RoomTypeController@index']);
                $router->post('/', ['as' => 'room_types.store', 'uses' => 'RoomTypeController@store']);
                $router->group(['prefix' => '/{id}'], function () use ($router) {
                    $router->get('/', ['as' => 'room_types.show', 'uses' => 'RoomTypeController@show']);
                    $router->put('/', ['as' => 'room_types.update', 'uses' => 'RoomTypeController@update']);
                    $router->delete('/', ['as' => 'room_types.delete', 'uses' => 'RoomTypeController@destroy']);
                });
            });


            /* 
            |-------------------------------------------------------------------------------
            | Routes for Accommodation Types
            |------------------------------------------------------------------------------
            */
            $router->group(['prefix' => 'accommodation_types'], function () use ($router) {
                $router->get('/', ['as' => 'accommodation_types.index', 'uses' => 'AccommodationTypeController@index']);
                $router->post('/', ['as' => 'accommodation_types.store', 'uses' => 'AccommodationTypeController@store']);
                $router->group(['prefix' => '/{id}'], function () use ($router) {
                    $router->get('/', ['as' => 'accommodation_types.show', 'uses' => 'AccommodationTypeController@show']);
                    $router->put('/', ['as' => 'accommodation_types.update', 'uses' => 'AccommodationTypeController@update']);
                    $router->delete('/', ['as' => 'accommodation_types.delete', 'uses' => 'AccommodationTypeController@destroy']);
                });
            });


            /* 
            |-------------------------------------------------------------------------------
            | Routes for Assignment Rooms
            |------------------------------------------------------------------------------
            */
            $router->group(['prefix' => 'assignment_room_types'], function () use ($router) {
                $router->get('/', ['as' => 'assignment_room_types.index', 'uses' => 'AssignmentRoomTypeController@index']);
                $router->post('/', ['as' => 'assignment_room_types.store', 'uses' => 'AssignmentRoomTypeController@store']);
                $router->group(['prefix' => '/{id}'], function () use ($router) {
                    $router->get('/', ['as' => 'assignment_room_types.show', 'uses' => 'AssignmentRoomTypeController@show']);
                    $router->put('/', ['as' => 'assignment_room_types.update', 'uses' => 'AssignmentRoomTypeController@update']);
                    $router->delete('/', ['as' => 'assignment_room_types.delete', 'uses' => 'AssignmentRoomTypeController@destroy']);
                });
            });
        });
    });


    /* 
    |-------------------------------------------------------------------------------
    | Routes for Hotels
    |------------------------------------------------------------------------------
    */
    $router->group(['prefix' => 'hotels'], function () use ($router) {
        $router->get('/', ['as' => 'hotels.index', 'uses' => 'HotelController@index']);
        $router->post('/', ['as' => 'hotels.store', 'uses' => 'HotelController@store']);
        $router->group(['prefix' => '/{id}'], function () use ($router) {
            $router->get('/', ['as' => 'hotels.show', 'uses' => 'HotelController@show']);
            $router->put('/', ['as' => 'hotels.update', 'uses' => 'HotelController@update']);
            $router->delete('/', ['as' => 'hotels.delete', 'uses' => 'HotelController@destroy']);
        });
    });

    /* 
    |-------------------------------------------------------------------------------
    | Routes for Rooms
    |------------------------------------------------------------------------------
    */
    $router->group(['prefix' => 'rooms'], function () use ($router) {
        $router->get('/', ['as' => 'rooms.index', 'uses' => 'RoomController@index']);
        $router->post('/', ['as' => 'rooms.store', 'uses' => 'RoomController@store']);
        $router->group(['prefix' => '/{id}'], function () use ($router) {
            $router->get('/', ['as' => 'rooms.show', 'uses' => 'RoomController@show']);
            $router->put('/', ['as' => 'rooms.update', 'uses' => 'RoomController@update']);
            $router->delete('/', ['as' => 'rooms.delete', 'uses' => 'RoomController@destroy']);
        });
    });
});
