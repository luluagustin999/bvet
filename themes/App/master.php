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
  <link rel="stylesheet" href="/libs/magnific-popup/dist/magnific-popup.css">
  <link id="themeColors" rel="stylesheet" href="/css/style.css" />
  <link rel="stylesheet" href="/css/anjing.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="/jpages/css/jPages.css" />

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
  <div class="page-wrapper" id="main-wrapper" data-layout="horizontal" data-theme="blue_theme" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="body-wrapper">
      <?= $this->include('_header') ?>
      <?= $this->renderSection("main") ?>
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
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="/jpages/js/jPages.min.js"></script>

  <!-- ---------------------------------------------- -->
  <!-- core files -->
  <!-- ---------------------------------------------- -->
  <script src="/js/app.min.js"></script>
  <script src="/js/app.init.js"></script>
  <script src="/js/app-style-switcher.js"></script>
  <script src="/js/sidebarmenu.js"></script>

  <script src="/js/custom.js"></script>
  <script src="/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
  <script src="/js/plugins/meg.init.js"></script>
  <!-- ---------------------------------------------- -->
  <!-- current page js files -->
  <!-- ---------------------------------------------- -->

  <!-- ---------------------------------------------- -->

  <script>
    new DataTable('#example');
  </script>
  <script>
    $(document).ready(function() {
      $("#pagination").jPages({
        containerID: "blog-container",
        perPage: 9,
        callback: function(pages, items) {
          // Add Bootstrap pagination styling
          $("#pagination").addClass("pagination");
          $("#pagination a, #pagination span").addClass("page-link");
          $("#pagination li").addClass("page-item");
        }
      });
    });
    $(document).ready(function() {
      $('.dropdown-submenu>a').unbind('click').click(function(e) {
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
      });
    });
  </script>



  <?= $this->renderSection('scripts') ?>
  <?= $viewMeta->render('script') ?>
  <?= $viewMeta->render('rawScripts') ?>
</body>

</html>