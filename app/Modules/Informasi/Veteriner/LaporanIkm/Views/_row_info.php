<td><?= esc($laporanikm->deskripsi) ?></td>
<td><?= esc($laporanikm->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('laporanikm.edit') || auth()->user()->can('laporanikm.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('laporanikm.edit')) : ?>
                    <li><a href="<?= url_to('laporanikm-edit', $laporanikm->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('laporanikm.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('laporanikm-delete', $laporanikm->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('LaporanIkm.laporanikm')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>