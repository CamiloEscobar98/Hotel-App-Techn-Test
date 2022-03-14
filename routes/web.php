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

$router->group(['prefix' => 'config/localization', 'namespace' => 'Localization'], function () use ($router) {
    $router->group(['prefix' => 'countries'], function () use ($router) {
        $router->get('/', ['as' => 'countries.index', 'uses' => 'CountryController@index']);
        $router->post('/', ['as' => 'countries.store', 'uses' => 'CountryController@store']);
        $router->group(['prefix' => '/{id}'], function () use ($router) {
            $router->get('/', ['as' => 'countries.show', 'uses' => 'CountryController@show']);
            $router->put('/', ['as' => 'countries.update', 'uses' => 'CountryController@update']);
            $router->delete('/', ['as' => 'countries.delete', 'uses' => 'CountryController@destroy']);
        });
    });
    $router->group(['prefix' => 'states'], function () use ($router) {
        $router->get('/', ['as' => 'states.index', 'uses' => 'StateController@index']);
        $router->post('/', ['as' => 'states.store', 'uses' => 'StateController@store']);
        $router->group(['prefix' => '/{id}'], function () use ($router) {
            $router->get('/', ['as' => 'states.show', 'uses' => 'StateController@show']);
            $router->put('/', ['as' => 'states.update', 'uses' => 'StateController@update']);
            $router->delete('/', ['as' => 'states.delete', 'uses' => 'StateController@destroy']);
        });
    });
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
