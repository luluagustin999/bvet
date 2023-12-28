<td><?= esc($pelayanan->id) ?></td>
<td><?= esc($pelayanan->title) ?></td>
<td><?= esc($pelayanan->excerpt) ?></td>
<td><?= esc($pelayanan->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('pelayanan.edit') || auth()->user()->can('pelayanan.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('pelayanan.edit')) : ?>
                    <li><a href="<?= url_to('pelayanan-edit', $pelayanan->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('pelayanan.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('pelayanan-delete', $pelayanan->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Pelayanan.pelayanan')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>