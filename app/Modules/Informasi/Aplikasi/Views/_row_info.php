<td><?= esc($aplikasi->layanan) ?></td>
<td><?= esc($aplikasi->link) ?></td>
<td><?= esc($aplikasi->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('aplikasi.edit') || auth()->user()->can('aplikasi.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('aplikasi.edit')) : ?>
                    <li><a href="<?= url_to('aplikasi-edit', $aplikasi->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('aplikasi.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('aplikasi-delete', $aplikasi->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Aplikasi.aplikasi')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>