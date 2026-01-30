<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/**
 * API Routes (Explicitly defined to prevent 404 and ensure Filters run correctly)
 */
$routes->get('api/member/profile', '\App\Controllers\Api\Member\Profile::getIndex', ['filter' => 'auth']);
$routes->post('api/member/profile/update', '\App\Controllers\Api\Member\Profile::postUpdate', ['filter' => 'auth']);
$routes->post('api/member/profile/change-password', '\App\Controllers\Api\Member\Profile::postChangePassword', ['filter' => 'auth']);

/**
 * SPA Catch-all Route
 * Melemparkan semua rute non-API ke entry point Vue
 */
$routes->get('^(?!api|statics|uploads)(.*)', 'Home::index');
