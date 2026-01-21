<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/**
 * Handle OPTIONS Preflight Request
 */
$routes->options('api/(:any)', function() {
    return service('response')->setStatusCode(200);
});

/**
 * API Routes (Manual Overrides for Auto Routing)
 */
$routes->get('api/profile', '\App\Controllers\Api\Member\Profile::getIndex', ['filter' => 'auth']);

/**
 * SPA Catch-all Route
 * Melemparkan semua rute non-API ke entry point Vue
 */
// $routes->get('(:any)', 'Home::index', ['filter' => 'cors']);