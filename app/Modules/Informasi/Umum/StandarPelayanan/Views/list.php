<?php $this->extend('master') ?>

<?php $this->section('main') ?>
<x-page-head>
  <div class="row">
    <div class="col">
      <h2><?= lang('StandarPelayanan.standarpelayananTitle') ?></h2>
    </div>
    <?php if (auth()->user()->can('standarpelayanan.create')) : ?>
      <div class="col-auto">
        <a href="<?= url_to('standarpelayanan-new') ?>" class="btn btn-primary"><?= lang('StandarPelayanan.newStandarPelayanan') ?></a>
      </div>
    <?php endif ?>
  </div>
</x-page-head>

<x-admin-box>
  <form action="<?= current_url() ?>" method="post" hx-post="<?= current_url() ?>" hx-trigger="submit" hx-target="#standarpelayanan-list">
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
      <!-- List StandarPelayanan -->
      <div class="col" id="standarpelayanan-list">
        <form action="<?= site_url(ADMIN_AREA . '/standarpelayanan/delete-batch') ?>" method="post">
          <?= csrf_field() ?>

          <?= $this->include('App\Modules\Informasi\Umum\StandarPelayanan\Views\_table') ?>
        </form>
      </div>

      <!-- Filters -->
      <div class="col-auto" x-show="filtered" x-transition.duration.240ms>
        <?= view_cell('Bonfire\Core\Cells\Filters::renderList', 'model=App\Modules\Informasi\Umum\StandarPelayanan\Models\StandarPelayananFilter target=#standarpelayanan-list') ?>
      </div>
    </div>
  </div>

</x-admin-box>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>

</script>
<?php $this->endSection() ?>