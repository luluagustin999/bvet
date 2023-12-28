<td><?= esc($informasiserta->deskripsi) ?></td>
<td><?= esc($informasiserta->category) ?></td>
<td><?= esc($informasiserta->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('informasiserta.edit') || auth()->user()->can('informasiserta.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('informasiserta.edit')) : ?>
                    <li><a href="<?= url_to('informasiserta-edit', $informasiserta->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('informasiserta.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('informasiserta-delete', $informasiserta->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('InformasiSerta.informasiserta')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>