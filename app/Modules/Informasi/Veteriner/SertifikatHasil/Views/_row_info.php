<td><?= esc($sertifikathasil->id) ?></td>
<td><?= esc($sertifikathasil->title) ?></td>
<td><?= esc($sertifikathasil->excerpt) ?></td>
<td><?= esc($sertifikathasil->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('sertifikathasil.edit') || auth()->user()->can('sertifikathasil.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('sertifikathasil.edit')) : ?>
                    <li><a href="<?= url_to('sertifikathasil-edit', $sertifikathasil->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('sertifikathasil.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('sertifikathasil-delete', $sertifikathasil->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('SertifikatHasil.sertifikathasil')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>