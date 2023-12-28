<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($informasiserta) && count($informasiserta)) : ?>
                <?php foreach ($informasiserta as $informasiserta) : ?>
                    <tr>
                        <?php if (auth()->user()->can('informasiserta.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $informasiserta->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Veteriner\InformasiSerta\Views\_row_info', ['informasiserta' => $informasiserta]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('informasiserta.delete')) : ?>
    <input type="submit" value="<?= lang('InformasiSerta.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>