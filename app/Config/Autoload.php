<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTOLOADER CONFIGURATION
 * -------------------------------------------------------------------
 *
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 *
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 *       the values in this file will overwrite the framework's values.
 *
 * NOTE: This class is required prior to Autoloader instantiation,
 *       and does not extend BaseConfig.
 *
 * @immutable
 */
class Autoload extends AutoloadConfig
{
  /**
   * -------------------------------------------------------------------
   * Namespaces
   * -------------------------------------------------------------------
   * This maps the locations of any namespaces in your application to
   * their location on the file system. These are used by the autoloader
   * to locate files the first time they have been instantiated.
   *
   * The '/app' and '/system' directories are already mapped for you.
   * you may change the name of the 'App' namespace if you wish,
   * but this should be done prior to creating any namespaced classes,
   * else you will need to modify all of those classes for this to work.
   *
   * Prototype:
   *   $psr4 = [
   *       'CodeIgniter' => SYSTEMPATH,
   *       'App'         => APPPATH
   *   ];
   *
   * @var array<string, array<int, string>|string>
   * @phpstan-var array<string, string|list<string>>
   */
  public $psr4 = [
    APP_NAMESPACE => APPPATH, // For custom app namespace
    'Config'      => APPPATH . 'Config',

    // Profile instansi
    'App\Modules\Profile\Instansi\Sejarah' => APPPATH . 'Modules/Profile/Instansi/Sejarah',
    'App\Modules\Profile\Instansi\VisiMisi' => APPPATH . 'Modules/Profile/Instansi/VisiMisi',
    'App\Modules\Profile\Instansi\Motto' => APPPATH . 'Modules/Profile/Instansi/Motto',
    'App\Modules\Profile\Instansi\Prestasi' => APPPATH . 'Modules/Profile/Instansi/Prestasi',
    'App\Modules\Profile\Instansi\Tupoksi' => APPPATH . 'Modules/Profile/Instansi/Tupoksi',
    'App\Modules\Profile\Instansi\AlurPelayanan' => APPPATH . 'Modules/Profile/Instansi/AlurPelayanan',
    'App\Modules\Profile\Instansi\MaklumatPelayanan' => APPPATH . 'Modules/Profile/Instansi/MaklumatPelayanan',
    'App\Modules\Profile\Instansi\KomitmenBersama' => APPPATH . 'Modules/Profile/Instansi/KomitmenBersama',
    'App\Modules\Profile\Instansi\KebijakanMutu' => APPPATH . 'Modules/Profile/Instansi/KebijakanMutu',
    'App\Modules\Profile\Instansi\KomitmenKeterbukaan' => APPPATH . 'Modules/Profile/Instansi/KomitmenKeterbukaan',
    'App\Modules\Profile\Instansi\StandarMutu' => APPPATH . 'Modules/Profile/Instansi/StandarMutu',

    // Profile SDM
    'App\Modules\Profile\SDM\StrukturOrganisasi' => APPPATH . 'Modules/Profile/SDM/StrukturOrganisasi',
    'App\Modules\Profile\SDM\PejabatStruktural' => APPPATH . 'Modules/Profile/SDM/PejabatStruktural',
    'App\Modules\Profile\SDM\DataPegawai' => APPPATH . 'Modules/Profile/SDM/DataPegawai',

    // Profile LAB
    'App\Modules\Profile\Laboratorium\Patologi' => APPPATH . 'Modules/Profile/Laboratorium/Patologi',
    'App\Modules\Profile\Laboratorium\Virologi' => APPPATH . 'Modules/Profile/Laboratorium/Virologi',
    'App\Modules\Profile\Laboratorium\Parasitologi' => APPPATH . 'Modules/Profile/Laboratorium/Parasitologi',
    'App\Modules\Profile\Laboratorium\Kemavet' => APPPATH . 'Modules/Profile/Laboratorium/Kemavet',
    'App\Modules\Profile\Laboratorium\Bioteknologi' => APPPATH . 'Modules/Profile/Laboratorium/Bioteknologi',
    'App\Modules\Profile\Laboratorium\Epidimologi' => APPPATH . 'Modules/Profile/Laboratorium/Epidimologi',
    'App\Modules\Profile\Laboratorium\Bakteriologi' => APPPATH . 'Modules/Profile/Laboratorium/Bakteriologi',
    'App\Modules\Profile\Laboratorium\Instalasi' => APPPATH . 'Modules/Profile/Laboratorium/Instalasi',

    // Profile LAB
    'App\Modules\Program\RencanaKerja' => APPPATH . 'Modules/Program/RencanaKerja',
    'App\Modules\Program\Anggaran' => APPPATH . 'Modules/Program/Anggaran',

    'App\Modules\Informasi\Umum\Berita' => APPPATH . 'Modules/Informasi/Umum/Berita',
    'App\Modules\Informasi\Umum\Publikasi' => APPPATH . 'Modules/Informasi/Umum/Publikasi',
    'App\Modules\Informasi\Umum\Pengumuman' => APPPATH . 'Modules/Informasi/Umum/Pengumuman',
    'App\Modules\Informasi\Umum\Gallery' => APPPATH . 'Modules/Informasi/Umum/Gallery',
    'App\Modules\Informasi\Umum\SOP' => APPPATH . 'Modules/Informasi/Umum/SOP',
    'App\Modules\Informasi\Umum\Agenda' => APPPATH . 'Modules/Informasi/Umum/Agenda',
    'App\Modules\Informasi\Umum\ExternalLink' => APPPATH . 'Modules/Informasi/Umum/ExternalLink',
    'App\Modules\Informasi\Umum\InternalLink' => APPPATH . 'Modules/Informasi/Umum/InternalLink',
    'App\Modules\Informasi\Umum\StandarPelayanan' => APPPATH . 'Modules/Informasi/Umum/StandarPelayanan',
    'App\Modules\Informasi\Umum\Pelayanan' => APPPATH . 'Modules/Informasi/Umum/Pelayanan',


    'App\Modules\Informasi\Aplikasi' => APPPATH . 'Modules/Informasi/Aplikasi',
    'App\Modules\Informasi\LayananPpid' => APPPATH . 'Modules/Informasi/LayananPpid',

    'App\Modules\Informasi\Veteriner\TarifPengujian' => APPPATH . 'Modules/Informasi/Veteriner/TarifPengujian',
    'App\Modules\Informasi\Veteriner\SertifikatHasil' => APPPATH . 'Modules/Informasi/Veteriner/SertifikatHasil',
    'App\Modules\Informasi\Veteriner\PantauPenyakit' => APPPATH . 'Modules/Informasi/Veteriner/PantauPenyakit',
    'App\Modules\Informasi\Veteriner\FormIkm' => APPPATH . 'Modules/Informasi/Veteriner/FormIkm',
    'App\Modules\Informasi\Veteriner\LaporanIkm' => APPPATH . 'Modules/Informasi/Veteriner/LaporanIkm',
    'App\Modules\Informasi\Veteriner\InformasiBerkala' => APPPATH . 'Modules/Informasi/Veteriner/InformasiBerkala',
    'App\Modules\Informasi\Veteriner\InformasiSetiap' => APPPATH . 'Modules/Informasi/Veteriner/InformasiSetiap',
    'App\Modules\Informasi\Veteriner\InformasiSerta' => APPPATH . 'Modules/Informasi/Veteriner/InformasiSerta',
    'App\Modules\Informasi\Veteriner\TataCara' => APPPATH . 'Modules/Informasi/Veteriner/TataCara',
    'App\Modules\Informasi\Veteriner\AlurPersyaratan' => APPPATH . 'Modules/Informasi/Veteriner/AlurPersyaratan',
    'App\Modules\Informasi\Veteriner\MekanismePengaduan' => APPPATH . 'Modules/Informasi/Veteriner/MekanismePengaduan',
    'App\Modules\Informasi\Veteriner\Pengaduan' => APPPATH . 'Modules/Informasi/Veteriner/Pengaduan',
    'App\Modules\Informasi\Veteriner\Pustaka' => APPPATH . 'Modules/Informasi/Veteriner/Pustaka',


  ];

  /**
   * -------------------------------------------------------------------
   * Class Map
   * -------------------------------------------------------------------
   * The class map provides a map of class names and their exact
   * location on the drive. Classes loaded in this manner will have
   * slightly faster performance because they will not have to be
   * searched for within one or more directories as they would if they
   * were being autoloaded through a namespace.
   *
   * Prototype:
   *   $classmap = [
   *       'MyClass'   => '/path/to/class/file.php'
   *   ];
   *
   * @var array<string, string>
   */
  public $classmap = [];

  /**
   * -------------------------------------------------------------------
   * Files
   * -------------------------------------------------------------------
   * The files array provides a list of paths to __non-class__ files
   * that will be autoloaded. This can be useful for bootstrap operations
   * or for loading functions.
   *
   * Prototype:
   *   $files = [
   *       '/path/to/my/file.php',
   *   ];
   *
   * @var string[]
   * @phpstan-var list<string>
   */
  public $files = [];

  /**
   * -------------------------------------------------------------------
   * Helpers
   * -------------------------------------------------------------------
   * Prototype:
   *   $helpers = [
   *       'form',
   *   ];
   *
   * @var string[]
   * @phpstan-var list<string>
   */
  public $helpers = ['auth', 'setting'];
}
