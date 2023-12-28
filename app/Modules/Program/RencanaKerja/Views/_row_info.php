<td><?= esc($rencanakerja->deskripsi) ?></td>
<td><?= esc($rencanakerja->category) ?></td>
<td><?= esc($rencanakerja->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('rencanakerja.edit') || auth()->user()->can('rencanakerja.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('rencanakerja.edit')) : ?>
                    <li><a href="<?= url_to('rencanakerja-edit', $rencanakerja->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('rencanakerja.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('rencanakerja-delete', $rencanakerja->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('RencanaKerja.rencanakerja')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>