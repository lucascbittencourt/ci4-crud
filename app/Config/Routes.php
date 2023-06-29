<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use App\Controllers\UserController;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group('users', static function ($routes) {
    $routes->get('', [UserController::class, 'index'], ['as' => 'users.index']);
    $routes->get('create', [UserController::class, 'create'], ['as' => 'users.create']);
    $routes->get('edit/(:num)', [UserController::class, 'edit'], ['as' => 'users.edit']);
});

$routes->group(
    'api',
    [
        'namespace' => 'App\Controllers\Api',
    ],
    static function ($routes) {
        $routes->group('users', static function ($routes) {
            $routes->get('', [\App\Controllers\Api\UserController::class, 'paginate'], ['as' => 'api.users.paginate']);
            $routes->post('', [\App\Controllers\Api\UserController::class, 'store'], ['as' => 'api.users.store']);
            $routes->put('(:num)', [\App\Controllers\Api\UserController::class, 'update'], ['as' => 'api.users.update']);
            $routes->delete('(:num)', [\App\Controllers\Api\UserController::class, 'delete'], ['as' => 'api.users.delete']);
        });
    }
);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
