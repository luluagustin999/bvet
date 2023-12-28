<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($sertifikathasil) && count($sertifikathasil)) : ?>
                <?php foreach ($sertifikathasil as $sertifikathasil) : ?>
                    <tr>
                        <?php if (auth()->user()->can('sertifikathasil.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $sertifikathasil->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Veteriner\SertifikatHasil\Views\_row_info', ['sertifikathasil' => $sertifikathasil]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('sertifikathasil.delete')) : ?>
    <input type="submit" value="<?= lang('SertifikatHasil.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>