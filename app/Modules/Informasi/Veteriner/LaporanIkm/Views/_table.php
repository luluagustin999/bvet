<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($laporanikm) && count($laporanikm)) : ?>
                <?php foreach ($laporanikm as $laporanikm) : ?>
                    <tr>
                        <?php if (auth()->user()->can('laporanikm.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $laporanikm->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Veteriner\LaporanIkm\Views\_row_info', ['laporanikm' => $laporanikm]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('laporanikm.delete')) : ?>
    <input type="submit" value="<?= lang('LaporanIkm.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>