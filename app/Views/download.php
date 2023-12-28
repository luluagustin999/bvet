<?= $this->extend('master') ?>

<?= $this->section('main') ?>

<div style="padding-top: 70px;"></div>
<div style="position: relative;" class="header">
  <div class="title">
    <h1 class="text-uppercase" style="letter-spacing: 3px; color:#FBCA00;"><?= $title ?></h1>
  </div>
</div>
<div class="container mt-5">
  <div class="row">
    <?php if (isset($menu)) : ?>
      <div class="col-lg-5 d-flex align-items-stretch">
        <div class="card w-100">
          <div class="card-body">
            <h5 class="card-title fw-semibold"><?= $title ?></h5>

            <?php foreach ($menu as $key => $value) : ?>
              <div class="mt-9 py-6 d-flex align-items-center">
                <div class="">
                  <a href="<?= $value ?>" style="color: #000000;" class="mb-0 fw-semibold"><?= $key ?></a>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    <?php endif ?>
    <div class="<?php echo isset($menu) ? 'col-lg-7' : 'col-lg-12' ?>">
      <?php if (isset($subtitle)) : ?>
        <h3 style="margin-bottom: 70px;"><?= $subtitle ?></h3>
      <?php endif ?>
      <table id="example" class="table table-striped" style="width:100%">
        <thead>
          <tr>
            <?php foreach ($header as $val) : ?>
              <th><?= $val ?></th>
            <?php endforeach ?>
          </tr>
        </thead>
        <tbody>
          <?= $content ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
