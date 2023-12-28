<td><?= esc($berita->id) ?></td>
<td><?= esc($berita->title) ?></td>
<td><?= esc($berita->excerpt) ?></td>
<td><?= esc($berita->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('berita.edit') || auth()->user()->can('berita.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('berita.edit')) : ?>
                    <li><a href="<?= url_to('berita-edit', $berita->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('berita.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('berita-delete', $berita->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Berita.berita')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>