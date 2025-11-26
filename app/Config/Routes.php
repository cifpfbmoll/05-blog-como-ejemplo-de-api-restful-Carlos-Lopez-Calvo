<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// API Routes Restaurante
$routes->get('dishes/search', 'Dishes::search');

$routes->resource('dishes');
$routes->resource('tables');
$routes->resource('reservations');
$routes->resource('orders');
