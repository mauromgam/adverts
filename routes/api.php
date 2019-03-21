<?php

/**
 * All requests (GET/POST/PUT/DELETE) to the adverts endpoints
 * ● Retrieve one advert √
 * ● Retrieve all adverts √
 */
Route::resource('adverts', 'Api\AdvertController');

/**
 * All requests (GET/POST/PUT/DELETE) to the categories endpoints
 * ● Retrieve all categories √
 * ● Retrieve one category √
 */
Route::resource('categories', 'Api\CategoryController');


/**
 * All requests (GET/POST/PUT/DELETE) to the users endpoints
 * ● Retrieve one user √
 */
Route::resource('users', 'Api\UserController');

/**
 * ● Retrieve all of a users adverts √
 */
Route::get('users/{id}/adverts', 'Api\UserController@getUsersAdverts')
    ->name('users-adverts');

/**
 * ● Retrieve a users latest advert √
 */
Route::get('users/{id}/latest-advert', 'Api\UserController@geLatesttUsersAdvert')
    ->name('users-latest-advert');
