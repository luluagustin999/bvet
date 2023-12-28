<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <a href="<?= site_url(ADMIN_AREA . '/internallink') ?>" class="back">&larr; <?= lang('InternalLink.internallinkTitle') ?></a>
  <h2><?= isset($internallink) ? lang('InternalLink.editInternalLink') : lang('InternalLink.newInternalLink') ?></h2>
</x-page-head>

<?php if (isset($internallink) && $internallink->deleted_at !== null) : ?>
  <div class="alert danger">
    <?= lang('InternalLink.internallinkWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($internallink->deleted_at)->humanize() ?>.
    <a href="<?= url_to('recycler-restore', 'internallink', $internallink->id) ?>"><?= lang('InternalLink.restoreInternalLink') ?></a>
  </div>
<?php endif ?>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($internallink) && $internallink !== null) : ?>
      <input type="hidden" name="id" value="<?= $internallink->id ?>">
    <?php endif ?>

    <div class="form-group col-12 col-lg-6">
      <label for="instansi" class="form-label">Instansi</label>
      <input type="text" hx-target="#instansi_error" hx-post="<?= site_url($adminLink . 'validateField/instansi') ?>" name="instansi" class="form-control" autocomplete="instansi" value="<?= old('instansi', $internallink->instansi ?? '') ?>">
      <p id="instansi_error" class="text-danger"><?php if (has_error('instansi')) echo error('instansi') ?></p>
    </div>


    <div class="form-group col-12 col-lg-6">
      <label for="alamat" class="form-label">Alamat</label>
      <input type="text" hx-target="#alamat_error" hx-post="<?= site_url($adminLink . 'validateField/alamat') ?>" name="alamat" class="form-control" autocomplete="alamat" value="<?= old('alamat', $internallink->alamat ?? '') ?>">
      <p id="alamat_error" class="text-danger"><?php if (has_error('alamat')) echo error('alamat') ?></p>
    </div>

    <div class="form-group col-12 col-lg-6">
      <label for="link" class="form-label">Link Website</label>
      <input type="text" hx-target="#link_error" hx-post="<?= site_url($adminLink . 'validateField/link') ?>" name="link" class="form-control" autocomplete="link" value="<?= old('link', $internallink->link ?? '') ?>">
      <p id="link_error" class="text-danger"><?php if (has_error('link')) echo error('link') ?></p>
    </div>

    <div class="text-end py-3">
      <input type="submit" value="<?= lang('InternalLink.saveInternalLink') ?>" class="btn btn-primary btn-lg">
    </div>

  </form>

</x-admin-box>
<?php $this->endSection() ?>