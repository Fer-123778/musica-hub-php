<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('canciones-ci', 'Canciones::index');
$routes->get('api/canciones', 'Canciones::apiJson');