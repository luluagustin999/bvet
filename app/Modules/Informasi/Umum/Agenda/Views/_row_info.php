<td><?= esc($agenda->tanggal) ?></td>
<td><?= esc($agenda->kegiatan) ?></td>
<td><?= esc($agenda->lokasi) ?></td>
<td><?= esc($agenda->created_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('agenda.edit') || auth()->user()->can('agenda.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('agenda.edit')) : ?>
                    <li><a href="<?= url_to('agenda-edit', $agenda->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('agenda.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('agenda-delete', $agenda->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Agenda.agenda')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>