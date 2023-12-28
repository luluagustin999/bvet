<!doctype html>
<html lang="<?= service('request')->getLocale() ?>">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="handheldfriendly" content="true" />
  <meta name="MobileOptimized" content="width" />
  <meta name="description" content="Mordenize" />
  <meta name="author" content="" />
  <meta name="keywords" content="Mordenize" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <?= $viewMeta->render('meta') ?>

  <?= $viewMeta->render('title') ?>

  <!-- --------------------------------------------------- -->
  <!-- Prism Js -->
  <!-- --------------------------------------------------- -->

  <!-- --------------------------------------------------- -->
  <!-- Core Css -->
  <!-- --------------------------------------------------- -->
  <link id="themeColors" rel="stylesheet" href="/css/style.css" />

  <?= asset_link('other/components/font-awesome/css/all.css', 'css') ?>
  <?= $this->renderSection('styles') ?>
  <?= $viewMeta->render('style') ?>
</head>

<body>

  <aside id="alerts-wrapper" style="position: absolute;top: 30px !important;right: 1% !important;left: auto !important;min-width: 20rem !important;z-index: 9999;">
    {alerts}
  </aside>

  <?php if (site_offline()) : ?>
    <div class="alert alert-secondary alert-offline">
      <?= lang('Bonfire.offlineNotice') ?>
      <a href="<?= site_url(ADMIN_AREA . '/settings/general') ?>"><?= lang('Bonfire.here') ?></a>.
    </div>
  <?php endif ?>
  <!-- --------------------------------------------------- -->
  <!-- Body Wrapper -->
  <!-- --------------------------------------------------- -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-theme="blue_theme" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <x-sidebar />
    <div class="body-wrapper">
      <?= $this->include('_header') ?>
      <div class="container-fluid">
        <?= $this->renderSection("main") ?>
      </div>
    </div>
  </div>

  <!-- ---------------------------------------------- -->
  <!-- Bonfire -->
  <!-- ---------------------------------------------- -->

  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://unpkg.com/htmx.org@1.5.0"></script>
  <?= asset_link('admin/js/admin.js', 'js') ?>

  <!-- ---------------------------------------------- -->
  <!-- Customizer -->
  <!-- ---------------------------------------------- -->

  <!------------------------------------------------ -->
  <!-- Import Js Files -->
  <!-- ---------------------------------------------- -->
  <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
  <script src="/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <!-- ---------------------------------------------- -->
  <!-- core files -->
  <!-- ---------------------------------------------- -->
  <script src="/js/app.min.js"></script>
  <script src="/js/app.init.js"></script>
  <script src="/js/app-style-switcher.js"></script>
  <script src="/js/sidebarmenu.js"></script>

  <script src="/js/custom.js"></script>

  <!-- ---------------------------------------------- -->
  <!-- current page js files -->
  <!-- ---------------------------------------------- -->

  <!-- ---------------------------------------------- -->

  <?= $this->renderSection('scripts') ?>
  <?= $viewMeta->render('script') ?>
  <?= $viewMeta->render('rawScripts') ?>
</body>

</html>