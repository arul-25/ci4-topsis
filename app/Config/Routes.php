<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('LoginController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'LoginController::index');
$routes->get('login', 'LoginController::index');
$routes->post('login/check', 'LoginController::check');

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'DashboardController::index');
    $routes->get('logout', 'DashboardController::logout');
    $routes->get('password_edit', 'DashboardController::password_edit');
    $routes->put('password_update', 'DashboardController::password_update');

    $routes->get('prodi', 'DashboardController::prodi');
    $routes->post('prodi_list', 'DashboardController::prodi_list');
    $routes->get('prodi_add', 'DashboardController::prodi_add');
    $routes->post('prodi_store', 'DashboardController::prodi_store');
    $routes->get('prodi_edit/(:any)', 'DashboardController::prodi_edit/$1');
    $routes->put('prodi_update', 'DashboardController::prodi_update');
    $routes->delete('prodi_delete', 'DashboardController::prodi_delete');

    $routes->get('mahasiswa', 'DashboardController::mahasiswa');
    $routes->post('mahasiswa_list', 'DashboardController::mahasiswa_list');
    $routes->get('mahasiswa_add', 'DashboardController::mahasiswa_add');
    $routes->post('mahasiswa_store', 'DashboardController::mahasiswa_store');
    $routes->get('mahasiswa_edit/(:any)', 'DashboardController::mahasiswa_edit/$1');
    $routes->put('mahasiswa_update', 'DashboardController::mahasiswa_update');
    $routes->delete('mahasiswa_delete', 'DashboardController::mahasiswa_delete');

    $routes->get('beasiswa', 'DashboardController::beasiswa');
    $routes->post('beasiswa_list', 'DashboardController::beasiswa_list');
    $routes->get('beasiswa_add', 'DashboardController::beasiswa_add');
    $routes->post('beasiswa_store', 'DashboardController::beasiswa_store');
    $routes->get('beasiswa_edit/(:any)', 'DashboardController::beasiswa_edit/$1');
    $routes->put('beasiswa_update', 'DashboardController::beasiswa_update');
    $routes->delete('beasiswa_delete', 'DashboardController::beasiswa_delete');

    $routes->get('kouta', 'DashboardController::kouta');
    $routes->post('kouta_list', 'DashboardController::kouta_list');
    $routes->get('kouta_add', 'DashboardController::kouta_add');
    $routes->post('kouta_store', 'DashboardController::kouta_store');
    $routes->get('kouta_edit/(:any)', 'DashboardController::kouta_edit/$1');
    $routes->put('kouta_update', 'DashboardController::kouta_update');
    $routes->delete('kouta_delete', 'DashboardController::kouta_delete');

    $routes->get('persyaratan', 'DashboardController::persyaratan');
    $routes->post('persyaratan_list', 'DashboardController::persyaratan_list');
    $routes->get('persyaratan_add', 'DashboardController::persyaratan_add');
    $routes->post('persyaratan_store', 'DashboardController::persyaratan_store');
    $routes->get('persyaratan_edit/(:any)', 'DashboardController::persyaratan_edit/$1');
    $routes->put('persyaratan_update', 'DashboardController::persyaratan_update');
    $routes->delete('persyaratan_delete', 'DashboardController::persyaratan_delete');

    $routes->get('bobot', 'DashboardController::bobot');
    $routes->post('bobot_list', 'DashboardController::bobot_list');
    $routes->get('bobot_add', 'DashboardController::bobot_add');
    $routes->post('bobot_store', 'DashboardController::bobot_store');
    $routes->get('bobot_edit/(:any)', 'DashboardController::bobot_edit/$1');
    $routes->put('bobot_update', 'DashboardController::bobot_update');
    $routes->delete('bobot_delete', 'DashboardController::bobot_delete');

    $routes->get('seleksi', 'DashboardController::seleksi');
    $routes->post('seleksi_list', 'DashboardController::seleksi_list');

    $routes->post('hasil_list', 'DashboardController::hasil_list');

    $routes->get('seleksi_add', 'DashboardController::seleksi_add');
    $routes->post('seleksi_store', 'DashboardController::seleksi_store');
    $routes->get('seleksi_edit/(:any)', 'DashboardController::seleksi_edit/$1');
    $routes->put('seleksi_update', 'DashboardController::seleksi_update');
    $routes->delete('seleksi_delete', 'DashboardController::seleksi_delete');
    $routes->get('seleksi_detail/(:any)', 'DashboardController::seleksi_detail/$1');
    $routes->post('seleksi_detail_update', 'DashboardController::seleksi_detail_update');

    $routes->get('cetak', 'DashboardController::cetak');

    $routes->match(['post', 'get'], 'hitung', 'DashboardController::hitung');

    $routes->match(['post', 'get'], 'hasil', 'DashboardController::hasil');
});


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
