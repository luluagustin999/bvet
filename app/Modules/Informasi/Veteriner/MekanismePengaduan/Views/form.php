<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <a href="<?= site_url(ADMIN_AREA . '/mekanismepengaduan') ?>" class="back">&larr; <?= lang('MekanismePengaduan.mekanismepengaduanTitle') ?></a>
  <h2><?= isset($mekanismepengaduan) ? lang('MekanismePengaduan.editMekanismePengaduan') : lang('MekanismePengaduan.newMekanismePengaduan') ?></h2>
</x-page-head>

<?php if (isset($mekanismepengaduan) && $mekanismepengaduan->deleted_at !== null) : ?>
  <div class="alert danger">
    <?= lang('MekanismePengaduan.mekanismepengaduanWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($mekanismepengaduan->deleted_at)->humanize() ?>.
    <a href="<?= url_to('recycler-restore', 'mekanismepengaduan', $mekanismepengaduan->id) ?>"><?= lang('MekanismePengaduan.restoreMekanismePengaduan') ?></a>
  </div>
<?php endif ?>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($mekanismepengaduan) && $mekanismepengaduan !== null) : ?>
      <input type="hidden" name="id" value="<?= $mekanismepengaduan->id ?>">
    <?php endif ?>

    <div class="row">
      <!-- Title -->
      <div class="form-group col-12 col-lg-6">
        <label for="title" class="form-label"><?= lang('MekanismePengaduan.title') ?></label>
        <input type="text" hx-target="#title_error" hx-post="<?= site_url($adminLink . 'validateField/title') ?>" name="title" class="form-control" autocomplete="title" value="<?= old('title', $mekanismepengaduan->title ?? '') ?>">
        <p id="title_error" class="text-danger"><?php if (has_error('title')) echo error('title') ?></p>
      </div>

      <!-- URL slug -->
      <?php if (isset($mekanismepengaduan) && $mekanismepengaduan !== null) : ?>
        <div class="form-group col-12 col-lg-6">
          <label for="slug" class="form-label"><?= lang('MekanismePengaduan.urlSlug') ?></label>
          <input type="text" hx-target="#slug_error" hx-trigger="keyup changed delay:500ms" hx-post="<?= site_url($adminLink . 'validateField/slug') ?>" name="slug" class="form-control form-control-sm" autocomplete="slug" value="<?= old('slug', $mekanismepengaduan->slug ?? '') ?>">
          <p id="slug_error" class="text-danger"><?php if (has_error('slug')) echo error('slug') ?></p>
        </div>
      <?php endif; ?>
    </div>

    <div class="row">
      <!-- Image -->
      <div class="form-group col-12">
        <label for="image" class="form-label">Image</label>
        <input class="form-control" type="file" id="formFile" name="image" />
        <p id="image_error" class="text-danger"><?php if (has_error('image')) echo error('image') ?></p>
      </div>
    </div>

    <div class="row">
      <!-- Image -->
      <div class="form-group col-12">
        <label for="image" class="form-label">Preview Image</label>
      </div>
      <div class="form-group col-12">
        <?php if (isset($mekanismepengaduan->image) && !empty($mekanismepengaduan->image)) : ?>
          <img id="imagePreview" src="<?= base_url($mekanismepengaduan->image); ?>" style="height: 500px; width: 100%; margin-bottom: 10px; padding: 30px; border: var(--bs-border-width) dashed #dfe5ef; border-radius: 10px;" />
        <?php else : ?>
          <!-- Display a placeholder or leave this blank -->
          <img id="imagePreview" style="height: 500px; width: 100%; margin-bottom: 10px; padding: 30px; border: var(--bs-border-width) dashed #dfe5ef; border-radius: 10px; display: none;" />
        <?php endif; ?>
      </div>
    </div>

    <div class="row">
      <!-- Content -->
      <div class="form-group col-12">
        <label for="content" class="form-label"><?= lang('MekanismePengaduan.content') ?></label>
        <textarea id="content" name="content" hx-target="#content_error" hx-post="<?= site_url($adminLink . 'validateField/content') ?>" class="form-control" rows="5" autocomplete="content"><?= old('content', $mekanismepengaduan->content ?? '') ?></textarea>
        <p id="content_error" class="text-danger"><?php if (has_error('content')) echo error('content') ?></p>
      </div>
    </div>

    <div class="text-end py-3">
      <input type="submit" value="<?= lang('MekanismePengaduan.saveMekanismePengaduan') ?>" class="btn btn-primary btn-lg">
    </div>

  </form>

</x-admin-box>
<script>
  document.getElementById('formFile').addEventListener('change', function(event) {
    var output = document.getElementById('imagePreview');
    if (event.target.files && event.target.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        output.src = e.target.result;
        output.style.display = 'block'; // Show the image element
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  });
</script>

<?php $this->endSection() ?>