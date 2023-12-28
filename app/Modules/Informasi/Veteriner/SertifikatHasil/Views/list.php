<?php $this->extend('master') ?>

<?php $this->section('main') ?>
<x-page-head>
  <div class="row">
    <div class="col">
      <h2><?= lang('SertifikatHasil.sertifikathasilTitle') ?></h2>
    </div>
    <?php if (auth()->user()->can('sertifikathasil.create')) : ?>
      <div class="col-auto">
        <a href="<?= url_to('sertifikathasil-new') ?>" class="btn btn-primary"><?= lang('SertifikatHasil.newSertifikatHasil') ?></a>
      </div>
    <?php endif ?>
  </div>
</x-page-head>

<x-admin-box>
  <form action="<?= current_url() ?>" method="post" hx-post="<?= current_url() ?>" hx-trigger="submit" hx-target="#sertifikathasil-list">
    <?= csrf_field() ?>
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search by title" name="search" value="<?= esc($searchQuery) ?>">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
    </div>
  </form>
  <div x-data="{filtered: false}">
    <x-filter-link />

    <div class="row">
      <!-- List SertifikatHasil -->
      <div class="col" id="sertifikathasil-list">
        <form action="<?= site_url(ADMIN_AREA . '/sertifikathasil/delete-batch') ?>" method="post">
          <?= csrf_field() ?>

          <?= $this->include('App\Modules\Informasi\Veteriner\SertifikatHasil\Views\_table') ?>
        </form>
      </div>

      <!-- Filters -->
      <div class="col-auto" x-show="filtered" x-transition.duration.240ms>
        <?= view_cell('Bonfire\Core\Cells\Filters::renderList', 'model=App\Modules\Informasi\Veteriner\SertifikatHasil\Models\SertifikatHasilFilter target=#sertifikathasil-list') ?>
      </div>
    </div>
  </div>

</x-admin-box>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

</script>
<?php $this->endSection() ?>