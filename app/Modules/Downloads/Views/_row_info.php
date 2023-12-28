<td><?= esc($download->deskripsi) ?></td>
<td><?= esc($download->category) ?></td>
<td><?= esc($download->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('downloads.edit') || auth()->user()->can('downloads.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('downloads.edit')) : ?>
                    <li><a href="<?= url_to('download-edit', $download->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('downloads.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('download-delete', $download->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Downloads.download')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>