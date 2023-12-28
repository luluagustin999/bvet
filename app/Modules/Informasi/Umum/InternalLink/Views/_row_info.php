<td><?= esc($internallink->instansi) ?></td>
<td><?= esc($internallink->alamat) ?></td>
<td><?= esc($internallink->link) ?></td>
<td><?= esc($internallink->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('internallink.edit') || auth()->user()->can('internallink.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('internallink.edit')) : ?>
                    <li><a href="<?= url_to('internallink-edit', $internallink->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('internallink.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('internallink-delete', $internallink->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('InternalLink.internallink')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>