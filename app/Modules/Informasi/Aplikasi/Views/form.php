<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <a href="<?= site_url(ADMIN_AREA . '/aplikasi') ?>" class="back">&larr; <?= lang('Aplikasi.aplikasiTitle') ?></a>
  <h2><?= isset($aplikasi) ? lang('Aplikasi.editAplikasi') : lang('Aplikasi.newAplikasi') ?></h2>
</x-page-head>

<?php if (isset($aplikasi) && $aplikasi->deleted_at !== null) : ?>
  <div class="alert danger">
    <?= lang('Aplikasi.aplikasiWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($aplikasi->deleted_at)->humanize() ?>.
    <a href="<?= url_to('recycler-restore', 'aplikasi', $aplikasi->id) ?>"><?= lang('Aplikasi.restoreAplikasi') ?></a>
  </div>
<?php endif ?>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($aplikasi) && $aplikasi !== null) : ?>
      <input type="hidden" name="id" value="<?= $aplikasi->id ?>">
    <?php endif ?>

    <div class="form-group col-12 col-lg-6">
      <label for="layanan" class="form-label">Layanan</label>
      <input type="text" hx-target="#layanan_error" hx-post="<?= site_url($adminLink . 'validateField/layanan') ?>" name="layanan" class="form-control" autocomplete="layanan" value="<?= old('layanan', $aplikasi->layanan ?? '') ?>">
      <p id="layanan_error" class="text-danger"><?php if (has_error('layanan')) echo error('layanan') ?></p>
    </div>

    <div class="form-group col-12 col-lg-6">
      <label for="link" class="form-label">Link Website</label>
      <input type="text" hx-target="#link_error" hx-post="<?= site_url($adminLink . 'validateField/link') ?>" name="link" class="form-control" autocomplete="link" value="<?= old('link', $aplikasi->link ?? '') ?>">
      <p id="link_error" class="text-danger"><?php if (has_error('link')) echo error('link') ?></p>
    </div>

    <div class="text-end py-3">
      <input type="submit" value="<?= lang('Aplikasi.saveAplikasi') ?>" class="btn btn-primary btn-lg">
    </div>

  </form>

</x-admin-box>
<?php $this->endSection() ?>