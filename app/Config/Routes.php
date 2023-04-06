<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->get('/',  'payroll\Dashboard::Index', ['filter' => 'permission:dashboard']);
$routes->group('admin/', ['filter' => 'permission:laporanbulanan'], function ($routes) {

    // payroll
    $routes->get('gantigrupsementara', 'payroll\Grup::Index');
    $routes->get('laporanbulanan', 'payroll\Laporan::Laporanbulanan');
    $routes->add('laporan/tabellaporanbulanan', 'payroll\Laporan::Tabelabsenlaporanbulanan');
    $routes->get('rekap', 'payroll\Rekap::Index');
    $routes->add('rekap/tabellaporanharian', 'payroll\Rekap::Tabelabsenlaporanharian');
    $routes->add('rekap', 'payroll\Rekap::Addrekap');
    $routes->add('izin', 'payroll\Izin::index');
    $routes->add('validasi', 'payroll\Izin::validasi');
    $routes->add('izin/tambahizin', 'payroll\Izin::Addizin');
    $routes->add('logizin', 'payroll\Izin::Logizin');
    $routes->add('logkaryawan', 'payroll\Karyawan::Logkaryawan');
    $routes->add('logkaryawan/datatables', 'payroll\Karyawan::Datatableslogkaryawan');
    $routes->add('logizin/datatables', 'payroll\Izin::Datatableslogizin');
    $routes->add('izin/datanamaform', 'payroll\Izin::Ajaxform');
    $routes->add('izin/delete', 'payroll\Izin::Delete');
    $routes->add('izin/ubahbs', 'payroll\Izin::Ubahbs');
    $routes->add('izin/ubahbt', 'payroll\Izin::Ubahbt');
    $routes->add('izin/fio', 'payroll\Izin::Fio');
    $routes->add('printrekap/rekapunit', 'payroll\Rekap::Printrekapunit');
    $routes->add('formizin/datatables', 'payroll\Izin::Formizin');
    $routes->add('formpizin/datatables', 'payroll\Izin::Formpizin');
    $routes->add('formtizin/datatables', 'payroll\Izin::Formtizin');

    // gudang
    $routes->get('gudang/inputmutasipenerimaan', 'Gudang\Produksi::InputMutasiPenerimaanBarangJadi');
    $routes->get('gudang/ajax/item', 'Gudang\Produksi::Searchitem');
});

$routes->group('admin/', ['filter' => 'permission:dashboard'], function ($routes) {
    $routes->get('', 'payroll\Dashboard::Index');
    $routes->add('dashboard/moreinfo', 'payroll\Dashboard::Detail');
});

$routes->group('admin/', ['filter' => 'permission:datakaryawan'], function ($routes) {
    $routes->get('karyawan', 'payroll\Karyawan::Index');
    $routes->add('karyawanjp3a/datatables', 'payroll\Karyawan::datatablesjp3a');
    $routes->add('karyawanjp3k/datatables', 'payroll\Karyawan::datatablesjp3k');
    $routes->add('karyawanjp3a/add', 'payroll\Karyawan::tambahkaryawanjp3');
    $routes->get('karyawan/detail/(:segment)', 'Payroll\Karyawan::Detaikaryawan/$1');
    $routes->add('karyawan/tambahkaryawan', 'payroll\Karyawan::Add');
    $routes->add('karyawan/idpembagian', 'payroll\Karyawan::Pembagian');
    $routes->add('karyawan/edit', 'payroll\Karyawan::Edit');
    $routes->add('karyawan/save', 'payroll\Karyawan::Save');
    $routes->add('karyawan/keluar', 'payroll\Karyawan::Keluar');
    $routes->add('diliburkan', 'payroll\Karyawan::Diliburkan');
    $routes->add('adddiliburkan', 'payroll\Karyawan::Adddiliburkan');
    $routes->add('deletediliburkan', 'payroll\Karyawan::Deletediliburkan');
    $routes->add('diliburkan/datatables', 'payroll\Karyawan::Datatablesdiliburkan');
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
