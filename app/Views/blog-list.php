<?= $this->extend('master') ?>

<?= $this->section('main') ?>

<div style="padding-top: 70px;"></div>
<div style="position: relative;" class="header">
  <div class="title">
    <h1 class="text-uppercase" style="letter-spacing: 3px; color:#FBCA00;"><?= $title ?></h1>
  </div>
</div>
<div class="container mt-5">
  <div id="blog-container" class="row">
    <!-- Blog posts here -->

    <?php foreach ($data as $value) : ?>
      <div class="col-md-6 col-lg-4">
        <div class="card rounded-2 overflow-hidden hover-img">
          <div class="position-relative">
            <a href="<?= base_url('berita/' . $value->slug) ?>"><img src="<?= base_url($value->image) ?>" class="card-img-top rounded-0" alt="..."></a>
          </div>
          <div class="card-body p-4">
            <span class="badge text-bg-light fs-2 rounded-4 py-1 px-2 lh-sm  mt-3"><?= $value->created_at ?></span>
            <a class="d-block my-4 fs-5 text-dark fw-semibold" href="<?= $value->title  ?>"></a>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>

  <!-- Pagination container -->
  <div id="pagination" class="pagination"></div>
</div>

<?= $this->endSection() ?>
