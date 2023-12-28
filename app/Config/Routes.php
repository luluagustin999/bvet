<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Pofile - Instansi
$routes->get('/sejarah', 'Sejarah::index');
$routes->get('/visimisi', 'VisiMisi::index');
$routes->get('/motto', 'Motto::index');
$routes->get('/prestasi-penghargaan', 'Prestasi::index');
$routes->get('/tupoksi', 'Tupoksi::index');
$routes->get('/alur-pelayanan', 'AlurPelayanan::index');
$routes->get('/maklumat-pelayanan', 'MaklumatPelayanan::index');
$routes->get('/komitmen-bersama', 'KomitmenBersama::index');
$routes->get('/kebijakan-mutu', 'KebijakanMutu::index');
$routes->get('/komitmen-keterbukaan', 'KomitmenKeterbukan::index');
$routes->get('/standar-mutu', 'StandarMutu::index');

// Profile - sumber daya manusia
$routes->get('/struktur-organisasi', 'StrukturOrganisasi::index');
$routes->get('/pejabat-struktural', 'PejabatStruktural::index');
$routes->get('/data-pegawai', 'DataPegawai::index');

// Profile - laboratoriumk
$routes->get('/patologi', 'Patologi::index');
$routes->get('/virologi', 'Virologi::index');
$routes->get('/parasitologi', 'Parasitologi::index');
$routes->get('/kemavet', 'Kemavet::index');
$routes->get('/bioteknologi', 'Bioteknologi::index');
$routes->get('/epidimiologi', 'Epidimiologi::index');
$routes->get('/bakteriologi', 'Bakteriologi::index');
$routes->get('/instalasi-hewan', 'InstalasiHewan::index');

// Program - Rencana Kerja
$routes->get('/rencana-kerja/(:any)', 'RencanaKerja::index/$1');

// Program - Anggaran
$routes->get('/anggaran/(:any)', 'Anggaran::index/$1');

$routes->get('/kinerja/(:any)', 'Kinerja::index/$1');

$routes->get('/berita/', 'Berita::index');
$routes->get('/berita/(:any)', 'Berita::page/$1');


$routes->get('/publikasi/(:any)', 'Publikasi::index/$1');

$routes->get('/pengumuman', 'Pengumuman::index');
$routes->get('/pengumuman/(:any)', 'Pengumuman::page/$1');

$routes->get('/sop', 'Sop::index');

$routes->get('/agenda', 'Agenda::index');

$routes->get('/external-link', 'ExternalLink::index');
$routes->get('/internal-link', 'InternalLink::index');

$routes->get('/standar-pelayanan-publik', 'StandarPelayanan::index');

$routes->get('/pelayanan-pkl', 'Pelayanan::index');
$routes->get('/pelayanan-pkl/(:any)', 'Pelayanan::page');

$routes->get('/tarif-pengujian', 'TarifPengujian::index');
$routes->get('/tarif-pengujian/(:any)', 'TarifPengujian::page');

$routes->get('/laporan-ikm', 'LaporanIkm::index');

$routes->get('/informasi-berkala/(:any)', 'InformasiBerkala::index/$1');
$routes->get('/informasi-setiap/(:any)', 'InformasiSetiap::index/$1');
$routes->get('/informasi-serta/(:any)', 'InformasiSerta::index/$1');

$routes->get('/tata-cara-pengiriman-sampel', 'TataCara::index');
$routes->get('/tata-cara-pengiriman-sampel/(:any)', 'TataCara::page');

$routes->get('/alur-pelayanan-dan-persyaratan', 'AlurPersyaratan::index');
$routes->get('/alur-pelayanan-dan-persyaratan/(:any)', 'AlurPersyaratan::page');

$routes->get('/mekanisme-pengaduan', 'MekanismePengaduan::index');
$routes->get('/mekanisme-pengaduan/(:any)', 'MekanismePengaduan::page');

$routes->get('/layanan-ppid', 'LayananPpid::index');
$routes->get('/aplikasi', 'Aplikasi::index');


$routes->get('/standar-mutu', 'StandarMutu::index');
$routes->get('/gallery', 'Gallery::index');

// php spark landing:copy Sejarah MaklumatPelayanan "MAKLUMAT PELAYANAN"
