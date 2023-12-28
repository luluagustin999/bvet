<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($rencanakerja) && count($rencanakerja)) : ?>
                <?php foreach ($rencanakerja as $rencanakerja) : ?>
                    <tr>
                        <?php if (auth()->user()->can('rencanakerja.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $rencanakerja->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Program\RencanaKerja\Views\_row_info', ['rencanakerja' => $rencanakerja]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('rencanakerja.delete')) : ?>
    <input type="submit" value="<?= lang('RencanaKerja.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>