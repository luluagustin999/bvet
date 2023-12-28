<td><?= esc($standarpelayanan->deskripsi) ?></td>
<td><?= esc($standarpelayanan->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('standarpelayanan.edit') || auth()->user()->can('standarpelayanan.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('standarpelayanan.edit')) : ?>
                    <li><a href="<?= url_to('standarpelayanan-edit', $standarpelayanan->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('standarpelayanan.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('standarpelayanan-delete', $standarpelayanan->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('StandarPelayanan.standarpelayanan')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>