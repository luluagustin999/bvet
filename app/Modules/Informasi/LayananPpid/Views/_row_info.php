<td><?= esc($layananppid->layanan) ?></td>
<td><?= esc($layananppid->link) ?></td>
<td><?= esc($layananppid->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('layananppid.edit') || auth()->user()->can('layananppid.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('layananppid.edit')) : ?>
                    <li><a href="<?= url_to('layananppid-edit', $layananppid->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('layananppid.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('layananppid-delete', $layananppid->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('LayananPpid.layananppid')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>