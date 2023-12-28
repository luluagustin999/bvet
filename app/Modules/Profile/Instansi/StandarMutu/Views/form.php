<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <a href="<?= site_url(ADMIN_AREA . '/standarmutu') ?>" class="back">&larr; <?= lang('StandarMutu.standarmutuTitle') ?></a>
  <h2><?= isset($standarmutu) ? lang('StandarMutu.editStandarMutu') : lang('StandarMutu.newStandarMutu') ?></h2>
</x-page-head>

<?php if (isset($standarmutu) && $standarmutu->deleted_at !== null) : ?>
  <div class="alert danger">
    <?= lang('StandarMutu.standarmutuWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($standarmutu->deleted_at)->humanize() ?>.
    <a href="<?= url_to('recycler-restore', 'standarmutu', $standarmutu->id) ?>"><?= lang('StandarMutu.restoreStandarMutu') ?></a>
  </div>
<?php endif ?>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($standarmutu) && $standarmutu !== null) : ?>
      <input type="hidden" name="id" value="<?= $standarmutu->id ?>">
    <?php endif ?>

    <div class="row">
      <!-- Title -->
      <div class="form-group col-12 col-lg-6">
        <label for="title" class="form-label"><?= lang('Blogs.title') ?></label>
        <input type="text" hx-target="#title_error" hx-post="<?= site_url($adminLink . 'validateField/title') ?>" name="title" class="form-control" autocomplete="title" value="<?= old('title', $standarmutu->title ?? '') ?>">
        <p id="title_error" class="text-danger"><?php if (has_error('title')) echo error('title') ?></p>
      </div>
    </div>

    <div class="row">
      <div class="form-group mb-4">
        <label for="types" class="form-label">Type</label>
        <select <?php if (isset($standarmutu))  echo 'disabled'; ?> name='type' class="form-select mr-sm-2" hx-get="<?= site_url($adminLink . 'types')  ?>" hx-target="#types" hx-indicator=".htmx-indicator">
          <?php foreach ($types as $type) : ?>
            <option value="<?= $type; ?>" <?= (isset($standarmutu) && isset($standarmutu->type) && $type == $standarmutu->type) ? 'selected' : ''; ?>>
              <?= $type; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="row" id="types">
      <!-- File -->
      <?php if (isset($standarmutu->type)) : ?>
        <?php if ($standarmutu->type == 'IMAGE') : ?>
          <?= $this->include('App\Modules\Profile\Instansi\StandarMutu\Views\_type_image') ?>
        <?php else :  ?>
          <?= $this->include('App\Modules\Profile\Instansi\StandarMutu\Views\_type_video') ?>
        <?php endif  ?>
      <?php else : ?>
        <?= $this->include('App\Modules\Profile\Instansi\StandarMutu\Views\_type_image') ?>
    </div>
  <?php endif; ?>

  <div class="text-end py-3">
    <input type="submit" value="<?= lang('StandarMutu.saveStandarMutu') ?>" class="btn btn-primary btn-lg">
  </div>

  </form>

</x-admin-box>
<?php $this->endSection() ?>