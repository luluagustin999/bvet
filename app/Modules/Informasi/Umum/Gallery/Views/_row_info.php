<td><?= esc($gallery->title) ?></td>
<td><?= esc($gallery->type) ?></td>
<td><?= esc($gallery->created_at) ?></td>
<td class="justify-content-end">
  <?php if (auth()->user()->can('gallery.edit') || auth()->user()->can('gallery.delete')) : ?>
    <!-- Action Menu -->
    <div class="dropdown">
      <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
      <ul class="dropdown-menu">
        <?php if (auth()->user()->can('gallery.edit')) : ?>
          <li><a href="<?= url_to('gallery-edit', $gallery->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
        <?php endif ?>
        <?php if (auth()->user()->can('gallery.delete')) : ?>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a href="<?= url_to('gallery-delete', $gallery->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Gallery.gallery')]) ?>)">
              <?= lang('Bonfire.delete') ?>
            </a>
          </li>
        <?php endif ?>
      </ul>
    </div>
  <?php endif ?>
</td>