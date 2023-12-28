<td><?= esc($tatacara->id) ?></td>
<td><?= esc($tatacara->title) ?></td>
<td><?= esc($tatacara->excerpt) ?></td>
<td><?= esc($tatacara->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('tatacara.edit') || auth()->user()->can('tatacara.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('tatacara.edit')) : ?>
                    <li><a href="<?= url_to('tatacara-edit', $tatacara->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('tatacara.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('tatacara-delete', $tatacara->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('TataCara.tatacara')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>