<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <h2><?= lang('FormIkm.formikmTitle') ?></h2>
</x-page-head>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($formikm) && $formikm !== null) : ?>
      <input type="hidden" name="id" value="<?= $formikm->id ?>">
    <?php endif ?>

    <div class="row">
      <div class="form-group col-12 col-lg-6">
        <label for="link" class="form-label">Link</label>
        <input type="text" hx-target="#link_error" hx-post="<?= site_url($adminLink . 'validateField/link') ?>" name="link" class="form-control" autocomplete="link" value="<?= old('link', $formikm->link ?? '') ?>">
        <p id="link_error" class="text-danger"><?php if (has_error('link')) echo error('link') ?></p>
      </div>
    </div>

    <div class="text-end py-3">
      <input type="submit" value="<?= lang('FormIkm.saveFormIkm') ?>" class="btn btn-primary btn-lg">
    </div>

  </form>

</x-admin-box>

<?php $this->endSection() ?>