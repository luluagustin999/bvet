<td><?= esc($mekanismepengaduan->id) ?></td>
<td><?= esc($mekanismepengaduan->title) ?></td>
<td><?= esc($mekanismepengaduan->excerpt) ?></td>
<td><?= esc($mekanismepengaduan->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('mekanismepengaduan.edit') || auth()->user()->can('mekanismepengaduan.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('mekanismepengaduan.edit')) : ?>
                    <li><a href="<?= url_to('mekanismepengaduan-edit', $mekanismepengaduan->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('mekanismepengaduan.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('mekanismepengaduan-delete', $mekanismepengaduan->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('MekanismePengaduan.mekanismepengaduan')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>