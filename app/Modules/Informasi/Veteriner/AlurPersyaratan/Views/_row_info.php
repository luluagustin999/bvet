<td><?= esc($alurpersyaratan->id) ?></td>
<td><?= esc($alurpersyaratan->title) ?></td>
<td><?= esc($alurpersyaratan->excerpt) ?></td>
<td><?= esc($alurpersyaratan->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('alurpersyaratan.edit') || auth()->user()->can('alurpersyaratan.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('alurpersyaratan.edit')) : ?>
                    <li><a href="<?= url_to('alurpersyaratan-edit', $alurpersyaratan->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('alurpersyaratan.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('alurpersyaratan-delete', $alurpersyaratan->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('AlurPersyaratan.alurpersyaratan')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>