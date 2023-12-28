<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <a href="<?= site_url(ADMIN_AREA . '/anggaran') ?>" class="back">&larr; <?= lang('Anggaran.anggaranTitle') ?></a>
  <h2><?= isset($anggaran) ? lang('Anggaran.editAnggaran') : lang('Anggaran.newAnggaran') ?></h2>
</x-page-head>

<?php if (isset($anggaran) && $anggaran->deleted_at !== null) : ?>
  <div class="alert danger">
    <?= lang('Anggaran.anggaranWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($anggaran->deleted_at)->humanize() ?>.
    <a href="<?= url_to('recycler-restore', 'anggaran', $anggaran->id) ?>"><?= lang('Anggaran.restoreAnggaran') ?></a>
  </div>
<?php endif ?>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($anggaran) && $anggaran !== null) : ?>
      <input type="hidden" name="id" value="<?= $anggaran->id ?>">
    <?php endif ?>

    <div class="row">
      <div class="form-group mb-4">
        <label for="categories" class="form-label">Kategori</label>
        <select name='category' class="form-select mr-sm-2" id="inlineFormCustomSelect">
          <option selected>Choose...</option>
          <?php foreach ($categories as $category) : ?>
            <option value="<?= $category; ?>" <?= (isset($anggaran) && isset($anggaran->category) && $category == $anggaran->category) ? 'selected' : ''; ?>>
              <?= $category; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

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
        <?php if (isset($anggaran->file) && !empty($anggaran->file)) : ?>
          <img id="filePreview" src="<?= base_url($anggaran->file); ?>" style="height: 500px; width: 100%; margin-bottom: 10px; padding: 30px; border: var(--bs-border-width) dashed #dfe5ef; border-radius: 10px;" />
          <a style="margin-left: 20px;" href=" <?php echo base_url($anggaran->file) ?>">Anggaran File</a>
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
        <textarea id="deskripsi" name="deskripsi" hx-target="#deskripsi_error" hx-post="<?= site_url($adminLink . 'validateField/deskripsi') ?>" class="form-control" rows="5" autocomplete="deskripsi"><?= old('deskripsi', $anggaran->deskripsi ?? '') ?></textarea>
        <p id="deskripsi_error" class="text-danger"><?php if (has_error('deskripsi')) echo error('deskripsi') ?></p>
      </div>
    </div>

    <div class="text-end py-3">
      <input type="submit" value="<?= lang('Anggaran.saveAnggaran') ?>" class="btn btn-primary btn-lg">
    </div>

  </form>

</x-admin-box>
<?php $this->endSection() ?>