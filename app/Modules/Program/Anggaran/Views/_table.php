<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($anggaran) && count($anggaran)) : ?>
                <?php foreach ($anggaran as $anggaran) : ?>
                    <tr>
                        <?php if (auth()->user()->can('anggaran.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $anggaran->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Program\Anggaran\Views\_row_info', ['anggaran' => $anggaran]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('anggaran.delete')) : ?>
    <input type="submit" value="<?= lang('Anggaran.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>