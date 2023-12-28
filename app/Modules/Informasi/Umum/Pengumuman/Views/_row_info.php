<td><?= esc($pengumuman->id) ?></td>
<td><?= esc($pengumuman->title) ?></td>
<td><?= esc($pengumuman->excerpt) ?></td>
<td><?= esc($pengumuman->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('pengumuman.edit') || auth()->user()->can('pengumuman.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('pengumuman.edit')) : ?>
                    <li><a href="<?= url_to('pengumuman-edit', $pengumuman->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('pengumuman.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('pengumuman-delete', $pengumuman->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Pengumuman.pengumuman')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>