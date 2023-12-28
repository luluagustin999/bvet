<?= $this->extend('master') ?>

<?= $this->section('main') ?>

<div style="padding-top: 70px;"></div>
<div style="position: relative;" class="header">
  <div class="title">
    <h1 class="text-uppercase" style="letter-spacing: 3px; color:#FBCA00;"><?= $title ?></h1>
  </div>
</div>
<div class="container mt-5">
  <div id="blog-container" class="row el-element-overlay">
    <!-- Blog posts here -->

    <?php foreach ($data as $value) : ?>
      <div class="col-lg-3 col-md-6">
        <div class="card overflow-hidden">
          <div class="el-card-item pb-3">
            <div style="height: 300px;" class="
                      el-card-avatar
                      mb-3
                      el-overlay-1

                      w-100
                      overflow-hidden
                      position-relative
                      text-center
                    ">
              <img src="<?= base_url($value->file) ?>" class="d-block position-relative  w-100" alt="user" />
              <div class="el-overlay w-100 overflow-hidden">
                <ul class="
                          list-style-none
                          el-info
                          text-white text-uppercase
                          d-inline-block
                          p-0
                        ">
                  <li class="el-item d-inline-block my-0 mx-1">
                    <a class="
                              btn
                              default
                              btn-outline
                              image-popup-vertical-fit
                              el-link
                              text-white
                              border-white
                            " href="<?= base_url($value->file) ?>"><i class="ti ti-search"></i></a>
                  </li>
                  <li class="el-item d-inline-block my-0 mx-1">
                    <a class="
                              btn
                              default
                              btn-outline
                              el-link
                              text-white
                              border-white
                            " href="javascript:void(0);"><i class="ti ti-link"></i></a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="el-card-content text-center">
              <h4 class="mb-0 fs-5"><?= $value->title ?></h4>

            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>

  <!-- Pagination container -->
  <div id="pagination" class="pagination"></div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>

</script>
<?= $this->endSection() ?>