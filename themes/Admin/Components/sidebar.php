<!-- --------------------------------------------------- -->
<!-- Sidebar -->
<!-- --------------------------------------------------- -->
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="./index.html" class="text-nowrap logo-img">
        <img src="/logo.jpg" class="dark-logo" width="200" alt="" />
      </a>
      <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8 text-muted"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">
        <!-- =================== -->
        <!-- Dashboard -->
        <!-- =================== -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="/admin" aria-expanded="false">
            <span>
              <i class="ti ti-aperture"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        <?php if (isset($menu)) : ?>
          <?php foreach ($menu->collections() as $collection) : ?>

            <?php if (in_array($collection->title, ['Profile', 'Content', 'Program', 'Kinerja', 'Informasi Publik', 'Informasi Veteriner'])) : ?>
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu"><?= $collection->title ?></span>
              </li>
            <?php endif ?>
            <?php if ($collection->hasVisibleItems()) : ?>
              <?php if ($collection->isCollapsible()) : ?>
                <li class="sidebar-item">
                  <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                    <span class="d-flex">
                      <?= $collection->icon ?>
                    </span>
                    <span class="hide-menu"><?= $collection->title ?></span>
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <?php foreach ($collection->items() as $item) : ?>
                      <?php if ($item->userCanSee()) : ?>
                        <li class="sidebar-item">
                          <a href="<?= $item->url ?>" class="sidebar-link">
                            <div class="round-16 d-flex align-items-center justify-content-center">
                              <i class="ti ti-circle"></i>
                            </div>
                            <span class="hide-menu"><?= $item->title ?></span>
                          </a>
                        </li>
                      <?php endif ?>
                    <?php endforeach ?>
                  </ul>
                </li>
              <?php else : ?>

                <?php foreach ($collection->items() as $item) : ?>
                  <?php if ($item->userCanSee()) : ?>
                    <li class="sidebar-item">
                      <a class="sidebar-link" href="<?= $item->url ?>" aria-expanded="false">
                        <span>
                          <?= $item->icon ?>
                        </span>
                        <span class="hide-menu">
                          <?= $item->title ?>
                        </span>
                      </a>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              <?php endif ?>
            <?php endif ?>
          <?php endforeach ?>
        <?php endif ?>
      </ul>
    </nav>
    <div class="fixed-profile p-3 bg-light-secondary rounded sidebar-ad mt-3">
      <div class="hstack gap-3">
        <div class="john-img">
          <img src="/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40" alt="">
        </div>
        <div class="john-title">
          <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
          <span class="fs-2 text-dark">Designer</span>
        </div>
        <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
          <i class="ti ti-power fs-6"></i>
        </button>
      </div>
    </div>
  </div>
</aside>