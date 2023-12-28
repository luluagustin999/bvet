<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <a href="<?= site_url(ADMIN_AREA . '/layananppid') ?>" class="back">&larr; <?= lang('LayananPpid.layananppidTitle') ?></a>
  <h2><?= isset($layananppid) ? lang('LayananPpid.editLayananPpid') : lang('LayananPpid.newLayananPpid') ?></h2>
</x-page-head>

<?php if (isset($layananppid) && $layananppid->deleted_at !== null) : ?>
  <div class="alert danger">
    <?= lang('LayananPpid.layananppidWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($layananppid->deleted_at)->humanize() ?>.
    <a href="<?= url_to('recycler-restore', 'layananppid', $layananppid->id) ?>"><?= lang('LayananPpid.restoreLayananPpid') ?></a>
  </div>
<?php endif ?>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($layananppid) && $layananppid !== null) : ?>
      <input type="hidden" name="id" value="<?= $layananppid->id ?>">
    <?php endif ?>

    <div class="form-group col-12 col-lg-6">
      <label for="layanan" class="form-label">Layanan</label>
      <input type="text" hx-target="#layanan_error" hx-post="<?= site_url($adminLink . 'validateField/layanan') ?>" name="layanan" class="form-control" autocomplete="layanan" value="<?= old('layanan', $layananppid->layanan ?? '') ?>">
      <p id="layanan_error" class="text-danger"><?php if (has_error('layanan')) echo error('layanan') ?></p>
    </div>

    <div class="form-group col-12 col-lg-6">
      <label for="link" class="form-label">Link Website</label>
      <input type="text" hx-target="#link_error" hx-post="<?= site_url($adminLink . 'validateField/link') ?>" name="link" class="form-control" autocomplete="link" value="<?= old('link', $layananppid->link ?? '') ?>">
      <p id="link_error" class="text-danger"><?php if (has_error('link')) echo error('link') ?></p>
    </div>

    <div class="text-end py-3">
      <input type="submit" value="<?= lang('LayananPpid.saveLayananPpid') ?>" class="btn btn-primary btn-lg">
    </div>

  </form>

</x-admin-box>
<?php $this->endSection() ?>