<td><?= esc($standarmutu->title) ?></td>
<td><?= esc($standarmutu->type) ?></td>
<td><?= esc($standarmutu->created_at) ?></td>
<td class="justify-content-end">
  <?php if (auth()->user()->can('standarmutu.edit') || auth()->user()->can('standarmutu.delete')) : ?>
    <!-- Action Menu -->
    <div class="dropdown">
      <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
      <ul class="dropdown-menu">
        <?php if (auth()->user()->can('standarmutu.edit')) : ?>
          <li><a href="<?= url_to('standarmutu-edit', $standarmutu->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
        <?php endif ?>
        <?php if (auth()->user()->can('standarmutu.delete')) : ?>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a href="<?= url_to('standarmutu-delete', $standarmutu->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('StandarMutu.standarmutu')]) ?>)">
              <?= lang('Bonfire.delete') ?>
            </a>
          </li>
        <?php endif ?>
      </ul>
    </div>
  <?php endif ?>
</td>