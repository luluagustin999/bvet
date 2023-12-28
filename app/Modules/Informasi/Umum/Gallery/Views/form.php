<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <a href="<?= site_url(ADMIN_AREA . '/gallery') ?>" class="back">&larr; <?= lang('Gallery.galleryTitle') ?></a>
  <h2><?= isset($gallery) ? lang('Gallery.editGallery') : lang('Gallery.newGallery') ?></h2>
</x-page-head>

<?php if (isset($gallery) && $gallery->deleted_at !== null) : ?>
  <div class="alert danger">
    <?= lang('Gallery.galleryWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($gallery->deleted_at)->humanize() ?>.
    <a href="<?= url_to('recycler-restore', 'gallery', $gallery->id) ?>"><?= lang('Gallery.restoreGallery') ?></a>
  </div>
<?php endif ?>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($gallery) && $gallery !== null) : ?>
      <input type="hidden" name="id" value="<?= $gallery->id ?>">
    <?php endif ?>

    <div class="row">
      <!-- Title -->
      <div class="form-group col-12 col-lg-6">
        <label for="title" class="form-label"><?= lang('Blogs.title') ?></label>
        <input type="text" hx-target="#title_error" hx-post="<?= site_url($adminLink . 'validateField/title') ?>" name="title" class="form-control" autocomplete="title" value="<?= old('title', $gallery->title ?? '') ?>">
        <p id="title_error" class="text-danger"><?php if (has_error('title')) echo error('title') ?></p>
      </div>
    </div>

    <div class="row">
      <div class="form-group mb-4">
        <label for="types" class="form-label">Type</label>
        <select <?php if (isset($gallery))  echo 'disabled'; ?> name='type' class="form-select mr-sm-2" hx-get="<?= site_url($adminLink . 'types')  ?>" hx-target="#types" hx-indicator=".htmx-indicator">
          <?php foreach ($types as $type) : ?>
            <option value="<?= $type; ?>" <?= (isset($gallery) && isset($gallery->type) && $type == $gallery->type) ? 'selected' : ''; ?>>
              <?= $type; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="row" id="types">
      <!-- File -->
      <?php if (isset($gallery->type)) : ?>
        <?php if ($gallery->type == 'IMAGE') : ?>
          <?= $this->include('App\Modules\Informasi\Umum\Gallery\Views\_type_image') ?>
        <?php else :  ?>
          <?= $this->include('App\Modules\Informasi\Umum\Gallery\Views\_type_video') ?>
        <?php endif  ?>
      <?php else : ?>
        <?= $this->include('App\Modules\Informasi\Umum\Gallery\Views\_type_image') ?>
    </div>
  <?php endif; ?>

  <div class="text-end py-3">
    <input type="submit" value="<?= lang('Gallery.saveGallery') ?>" class="btn btn-primary btn-lg">
  </div>

  </form>

</x-admin-box>
<?php $this->endSection() ?>