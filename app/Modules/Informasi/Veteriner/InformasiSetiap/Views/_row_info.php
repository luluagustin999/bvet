<td><?= esc($informasisetiap->deskripsi) ?></td>
<td><?= esc($informasisetiap->category) ?></td>
<td><?= esc($informasisetiap->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('informasisetiap.edit') || auth()->user()->can('informasisetiap.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('informasisetiap.edit')) : ?>
                    <li><a href="<?= url_to('informasisetiap-edit', $informasisetiap->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('informasisetiap.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('informasisetiap-delete', $informasisetiap->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('InformasiSetiap.informasisetiap')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>