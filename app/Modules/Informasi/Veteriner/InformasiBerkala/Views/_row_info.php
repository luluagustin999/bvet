<td><?= esc($informasiberkala->deskripsi) ?></td>
<td><?= esc($informasiberkala->category) ?></td>
<td><?= esc($informasiberkala->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('informasiberkala.edit') || auth()->user()->can('informasiberkala.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('informasiberkala.edit')) : ?>
                    <li><a href="<?= url_to('informasiberkala-edit', $informasiberkala->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('informasiberkala.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('informasiberkala-delete', $informasiberkala->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('InformasiBerkala.informasiberkala')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>