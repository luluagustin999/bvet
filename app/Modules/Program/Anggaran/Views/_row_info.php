<td><?= esc($anggaran->deskripsi) ?></td>
<td><?= esc($anggaran->category) ?></td>
<td><?= esc($anggaran->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('anggaran.edit') || auth()->user()->can('anggaran.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('anggaran.edit')) : ?>
                    <li><a href="<?= url_to('anggaran-edit', $anggaran->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('anggaran.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('anggaran-delete', $anggaran->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Anggaran.anggaran')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>