<td><?= esc($publikasi->deskripsi) ?></td>
<td><?= esc($publikasi->category) ?></td>
<td><?= esc($publikasi->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('publikasi.edit') || auth()->user()->can('publikasi.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('publikasi.edit')) : ?>
                    <li><a href="<?= url_to('publikasi-edit', $publikasi->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('publikasi.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('publikasi-delete', $publikasi->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Publikasi.publikasi')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>