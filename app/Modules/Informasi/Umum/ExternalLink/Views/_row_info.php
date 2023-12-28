<td><?= esc($externallink->instansi) ?></td>
<td><?= esc($externallink->alamat) ?></td>
<td><?= esc($externallink->link) ?></td>
<td><?= esc($externallink->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('externallink.edit') || auth()->user()->can('externallink.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('externallink.edit')) : ?>
                    <li><a href="<?= url_to('externallink-edit', $externallink->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('externallink.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('externallink-delete', $externallink->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('ExternalLink.externallink')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>