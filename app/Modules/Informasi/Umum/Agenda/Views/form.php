<?php $this->extend('master') ?>
<?php $this->section('main') ?>
<x-page-head>
  <a href="<?= site_url(ADMIN_AREA . '/agenda') ?>" class="back">&larr; <?= lang('Agenda.agendaTitle') ?></a>
  <h2><?= isset($agenda) ? lang('Agenda.editAgenda') : lang('Agenda.newAgenda') ?></h2>
</x-page-head>

<?php if (isset($agenda) && $agenda->deleted_at !== null) : ?>
  <div class="alert danger">
    <?= lang('Agenda.agendaWasDeleted') . ' ' . CodeIgniter\I18n\Time::parse($agenda->deleted_at)->humanize() ?>.
    <a href="<?= url_to('recycler-restore', 'agenda', $agenda->id) ?>"><?= lang('Agenda.restoreAgenda') ?></a>
  </div>
<?php endif ?>

<x-admin-box>
  <form action="<?= site_url($adminLink . 'save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($agenda) && $agenda !== null) : ?>
      <input type="hidden" name="id" value="<?= $agenda->id ?>">
    <?php endif ?>

    <div class="form-group col-12 col-lg-6">
      <label for="categories" class="form-label">Tanggal</label>
      <input type="date" hx-target="#tanggal_error" hx-post="<?= site_url($adminLink . 'validateField/tanggal') ?>" name="tanggal" class="form-control" autocomplete="tanggal" value="<?= old('tanggal', $agenda->tanggal ?? '') ?>">
      <p id="tanggal_error" class="text-danger"><?php if (has_error('tanggal')) echo error('tanggal') ?></p>
    </div>


    <div class="form-group col-12 col-lg-6">
      <label for="kegiatan" class="form-label">Nama Kegiatan</label>
      <input type="text" hx-target="#kegiatan_error" hx-post="<?= site_url($adminLink . 'validateField/kegiatan') ?>" name="kegiatan" class="form-control" autocomplete="kegiatan" value="<?= old('kegiatan', $agenda->kegiatan ?? '') ?>">
      <p id="kegiatan_error" class="text-danger"><?php if (has_error('kegiatan')) echo error('kegiatan') ?></p>
    </div>

    <div class="form-group col-12 col-lg-6">
      <label for="lokasi" class="form-label">Lokasi</label>
      <input type="text" hx-target="#lokasi_error" hx-post="<?= site_url($adminLink . 'validateField/lokasi') ?>" name="lokasi" class="form-control" autocomplete="lokasi" value="<?= old('lokasi', $agenda->lokasi ?? '') ?>">
      <p id="lokasi_error" class="text-danger"><?php if (has_error('lokasi')) echo error('lokasi') ?></p>
    </div>

    <div class="text-end py-3">
      <input type="submit" value="<?= lang('Agenda.saveAgenda') ?>" class="btn btn-primary btn-lg">
    </div>

  </form>

</x-admin-box>
<?php $this->endSection() ?>