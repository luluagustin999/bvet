<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <h2><?= lang('Parasitologi.parasitologiTitle') ?></h2>
</x-page-head>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($parasitologi) && $parasitologi !== null) : ?>
      <input type="hidden" name="id" value="<?= $parasitologi->id ?>">
    <?php endif ?>

    <div class="row">
      <!-- Content -->
      <div class="form-group col-12">
        <label for="content" class="form-label"><?= lang('Parasitologi.content') ?></label>
        <textarea id="content" name="content" hx-target="#content_error" hx-post="<?= site_url($adminLink . 'validateField/content') ?>" class="form-control" rows="5" autocomplete="content"><?= old('content', $parasitologi->content ?? '') ?></textarea>
        <p id="content_error" class="text-danger"><?php if (has_error('content')) echo error('content') ?></p>
      </div>
    </div>

    <div class="text-end py-3">
      <input type="submit" value="<?= lang('Parasitologi.saveParasitologi') ?>" class="btn btn-primary btn-lg">
    </div>

  </form>

</x-admin-box>

<?php $this->endSection() ?>