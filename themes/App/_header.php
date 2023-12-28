<style>
  .dropdown-item:hover {
    color: rgb(44, 100, 204) !important;
    background-color: #d7e5ff !important;
  }

  .dropdown .dropdown-menu {
    display: none;
    position: absolute;
  }

  .dropdown:hover>.dropdown-menu,
  .dropend:hover>.dropdown-menu {
    position: absolute;
    display: block;
    margin-top: 0.125em;
    /* margin-left: 0.125em; */
  }

  @media screen and (min-width: 769px) {
    .dropend:hover>.dropdown-menu {
      position: absolute;
      top: 0;
      left: 100%;
    }


  }
</style>
<header class="app-header fixed-header" style="background: white;">
  <nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item d-block d-lg-none">
        <a class="nav-link sidebartoggler ms-n3" id="sidebarCollapse" href="/javascript:void(0)">
          <i class="ti ti-menu-2"></i>
        </a>
      </li>
      <li class="nav-item d-none d-lg-block">
        <a href="/" class="text-nowrap nav-link">
          <img src="/logo.jpg" class="dark-logo" width="340" alt="">
        </a>
      </li>
    </ul>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav quick-links d-none d-lg-flex">
        <li class="nav-item dropdown-hover d-none d-lg-block">
          <a class="nav-link" href="/home">BERANDA</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            PROFILE
          </a>
          <ul class="dropdown-menu">
            <li class="nav-item dropend">
              <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                INSTANSI
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/sejarah">Sejarah</a></li>
                <li><a class="dropdown-item" href="/visimisi">Visi & Misi</a></li>
                <li><a class="dropdown-item" href="/motto">Moto</a></li>
                <li><a class="dropdown-item" href="/prestasi-penghargaan">Prestasi / Penghargaan</a></li>
                <li><a class="dropdown-item" href="/tupoksi">Tupoksi</a></li>
                <li><a class="dropdown-item" href="/alur-pelayanan">Alur Pelayanan</a></li>
                <li><a class="dropdown-item" href="/maklumat-pelayanan">Maklumat Pelayanan</a></li>
                <li><a class="dropdown-item" href="/komitmen-bersama">Komitmen Bersama</a></li>
                <li><a class="dropdown-item" href="/kebijakan-mutu">Kebijakan Mutu & Anti Penipuan</a></li>
                <li><a class="dropdown-item" href="/komitmen-keterbukaan">Komitmen Keterbukaan Informasi</a></li>
                <li><a class="dropdown-item" href="/standar-mutu">Standar Mutu</a></li>
              </ul>
            </li>
            <li class="nav-item dropend">
              <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                SUMBER DAYA MANUSIA
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/struktur-organisasi">Struktur Organisasi</a></li>
                <li><a class="dropdown-item" href="/pejabat-struktural">Pejabat Struktural</a></li>
                <li><a class="dropdown-item" href="/data-pegawai">Data Pegawai</a></li>
              </ul>
            </li>
            <li class="nav-item dropend">
              <a class=" dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                LABORATORIUM
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/patologi">Lab. Patologi</a></li>
                <li><a class="dropdown-item" href="/virologi">Lab. Virologi</a></li>
                <li><a class="dropdown-item" href="/parasitologi">Lab. Parasitologi</a></li>
                <li><a class="dropdown-item" href="/kemavet">Lab. Kemavet</a></li>
                <li><a class="dropdown-item" href="/bioteknologi">Lab. Bioteknologi</a></li>
                <li><a class="dropdown-item" href="/epidimiologi">Lab. Epidimiologi</a></li>
                <li><a class="dropdown-item" href="/bakteriologi">Lab. Bakteriologi</a></li>
                <li><a class="dropdown-item" href="/instalasi-hewan">Instalasi Hewan Percobaan</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            PROGRAM
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/rencana-kerja/rencana-strategis">Rencana Kerja</a></li>
            <li><a class="dropdown-item" href="/anggaran/dipa">Anggaran</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown-hover d-none d-lg-block">
          <a class="nav-link" href="/kinerja/laporan-keuangan">KINERJA</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            INFORMASI PUBLIK
          </a>
          <ul class="dropdown-menu">
            <li class="nav-item dropend">
              <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Informasi Umum
              </a>
              <ul class="dropdown-menu">

                <li><a class="dropdown-item" href="/berita">Berita</a></li>
                <li><a class="dropdown-item" href="/publikasi/artikel">Publikasi</a></li>
                <li><a class="dropdown-item" href="/pengumuman">Pengumuman</a></li>
                <li><a class="dropdown-item" href="/gallery">Gallery</a></li>
                <li><a class="dropdown-item" href="/sop">SOP</a></li>
                <li><a class="dropdown-item" href="/agenda">Agenda</a></li>
                <li><a class="dropdown-item" href="/external-link">Eksternal Link</a></li>
                <li><a class="dropdown-item" href="/internal-link">Internal Link</a></li>
                <li><a class="dropdown-item" href="/standar-pelayanan-publik">Standar Pelayanan Publik</a></li>
                <li><a class="dropdown-item" href="/pelayanan-pkl">Pelayanan PKL/Magang/Bimbingan Teknis</a></li>
              </ul>
            </li>
            <li class="nav-item dropend">
              <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Informasi Veteriner
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/tarif-pengujian">Tarif Pengajuan</a></li>
                <li><a class="dropdown-item" href="#">Sertifikat Hasil Pengujian</a></li>
                <li><a class="dropdown-item" href="#">Pantau Penyakit</a></li>
                <li class="nav-item dropend">
                  <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    IKM
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Form Ikm</a></li>
                    <li><a class="dropdown-item" href="/laporan-ikm">Laporan Ikm</a></li>
                  </ul>
                </li>
                <li class="nav-item dropend">
                  <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Informasi Publik
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/informasi-berkala/laporan-lhkpn">Informasi Berkala</a></li>
                    <li><a class="dropdown-item" href="/informasi-setiap/laporan-perjanjian-kerjasama">Informasi Setiap Saat</a></li>
                    <li><a class="dropdown-item" href="/informasi-serta/pencegahan-covid19">Informasi Serta Merta</a></li>
                  </ul>
                </li>
                <li class="nav-item dropend">
                  <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Pelayanan Publik
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/tata-cara-pengiriman-sampel">Tata Cara Pengiriman Sampel</a></li>
                    <li><a class="dropdown-item" href="/alur-pelayanan-dan-persyaratan">Alur Pelayanan Dan Persyaratan</a></li>
                    <li><a class="dropdown-item" href="/mekanisme-pengaduan">Mekanisme Pengaduan</a></li>
                  </ul>
                </li>

                <li><a class="dropdown-item" href="#">Pengaduan Masyarakat</a></li>
                <li><a class="dropdown-item" href="#">Pustaka Online</a></li>
              </ul>
            </li>
            <li><a class="dropdown-item" href="/layanan-ppid">Layanan PPID</a></li>
            <li><a class="dropdown-item" href="/aplikasi">Aplikasi</a></li>
          </ul>

        </li>
      </ul>
    </div>
    <div class="d-block d-lg-none">
      <a href="/" class="text-nowrap nav-link">
        <img src="/logo.jpg" width="300" alt="">
      </a>
    </div>
  </nav>
</header>
<!-- <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    PROFILE
  </a>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#">Action</a></li>
    <li><a class="dropdown-item" href="#">Another action</a></li>
    <li>
      <hr class="dropdown-divider">
    </li>
    <li class="nav-item dropend">
      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Dropdown
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li class="nav-item dropend">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="nav-item dropend">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</li> -->