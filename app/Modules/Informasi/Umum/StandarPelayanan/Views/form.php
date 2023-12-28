<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <a href="<?= site_url(ADMIN_AREA . '/standarpelayanan') ?>" class="back">&larr; <?= lang('StandarPelayanan.standarpelayananTitle') ?></a>
  <h2><?= isset($standarpelayanan) ? lang('StandarPelayanan.editStandarPelayanan') : lang('StandarPelayanan.newStandarPelayanan') ?></h2>
</x-page-head>

<?php if (isset($standarpelayanan) && $standarpelayanan->deleted_at !== null) : ?>
  <div class="alert danger">
    <?= lang('StandarPelayanan.standarpelayananWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($standarpelayanan->deleted_at)->humanize() ?>.
    <a href="<?= url_to('recycler-restore', 'standarpelayanan', $standarpelayanan->id) ?>"><?= lang('StandarPelayanan.restoreStandarPelayanan') ?></a>
  </div>
<?php endif ?>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($standarpelayanan) && $standarpelayanan !== null) : ?>
      <input type="hidden" name="id" value="<?= $standarpelayanan->id ?>">
    <?php endif ?>

    <div class="row">
      <!-- File -->
      <div class="form-group col-12">
        <label for="file" class="form-label">File</label>
        <input class="form-control" type="file" id="formFile" name="file" />
        <p id="file_error" class="text-danger"><?php if (has_error('file')) echo error('file') ?></p>
      </div>
    </div>

    <div class="row">
      <!-- Preview File -->
      <div class="form-group col-12">
        <label for="file" class="form-label">Preview File</label>
      </div>
      <div class="form-group col-12">
        <?php if (isset($standarpelayanan->file) && !empty($standarpelayanan->file)) : ?>
          <img id="filePreview" src="<?= base_url($standarpelayanan->file); ?>" style="height: 500px; width: 100%; margin-bottom: 10px; padding: 30px; border: var(--bs-border-width) dashed #dfe5ef; border-radius: 10px;" />
          <a style="margin-left: 20px;" href=" <?php echo base_url($standarpelayanan->file) ?>">StandarPelayanan File</a>
        <?php else : ?>
          <!-- Display a placeholder or leave this blank -->
          <img id="filePreview" style="height: 500px; width: 100%; margin-bottom: 10px; padding: 30px; border: var(--bs-border-width) dashed #dfe5ef; border-radius: 10px; display: none;" />
        <?php endif; ?>
      </div>
    </div>

    <div class="row">
      <!-- Content -->
      <div class="form-group col-12">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" hx-target="#deskripsi_error" hx-post="<?= site_url($adminLink . 'validateField/deskripsi') ?>" class="form-control" rows="5" autocomplete="deskripsi"><?= old('deskripsi', $standarpelayanan->deskripsi ?? '') ?></textarea>
        <p id="deskripsi_error" class="text-danger"><?php if (has_error('deskripsi')) echo error('deskripsi') ?></p>
      </div>
    </div>

    <div class="text-end py-3">
      <input type="submit" value="<?= lang('StandarPelayanan.saveStandarPelayanan') ?>" class="btn btn-primary btn-lg">
    </div>

  </form>

</x-admin-box>
<?php $this->endSection() ?>