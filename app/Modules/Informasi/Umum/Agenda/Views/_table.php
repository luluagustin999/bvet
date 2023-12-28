<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($agenda) && count($agenda)) : ?>
                <?php foreach ($agenda as $agenda) : ?>
                    <tr>
                        <?php if (auth()->user()->can('agenda.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $agenda->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Umum\Agenda\Views\_row_info', ['agenda' => $agenda]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('agenda.delete')) : ?>
    <input type="submit" value="<?= lang('Agenda.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>