<td><?= esc($tarifpengujian->id) ?></td>
<td><?= esc($tarifpengujian->title) ?></td>
<td><?= esc($tarifpengujian->excerpt) ?></td>
<td><?= esc($tarifpengujian->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('tarifpengujian.edit') || auth()->user()->can('tarifpengujian.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('tarifpengujian.edit')) : ?>
                    <li><a href="<?= url_to('tarifpengujian-edit', $tarifpengujian->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('tarifpengujian.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('tarifpengujian-delete', $tarifpengujian->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('TarifPengujian.tarifpengujian')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>