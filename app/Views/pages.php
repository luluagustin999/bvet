<?= $this->extend('master') ?>

<?= $this->section('main') ?>

<div style="padding-top: 70px;"></div>
<div style="position: relative;" class="header">
  <div class="title">
    <h1 class="text-uppercase" style="letter-spacing: 3px; color:#000000;"><?= $title ?></h1>
  </div>
</div>
<div class="container mt-5">

  <?php if (isset($content->title)) : ?>
    <div style="margin-bottom: 70px;">
      <h3> <?= $content->title ?></h3>
      <small class="text-muted"><?= $content->created_at ?></small>
    </div>
    <div>
      <?php if (isset($content->image)) : ?>
        <img src="<?= base_url($content->image) ?>" alt="berita" class="img-responsive" width="750px">
      <?php endif ?>
    </div>
  <?php endif ?>
  <?php if (isset($content->content)) : ?>
    <?= $content->content ?>
  <?php endif ?>
</div>


<?= $this->endSection() ?>