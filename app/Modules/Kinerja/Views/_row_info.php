<td><?= esc($kinerja->deskripsi) ?></td>
<td><?= esc($kinerja->category) ?></td>
<td><?= esc($kinerja->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('kinerja.edit') || auth()->user()->can('kinerja.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('kinerja.edit')) : ?>
                    <li><a href="<?= url_to('kinerja-edit', $kinerja->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('kinerja.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('kinerja-delete', $kinerja->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Kinerja.kinerja')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>