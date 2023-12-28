<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($standarpelayanan) && count($standarpelayanan)) : ?>
                <?php foreach ($standarpelayanan as $standarpelayanan) : ?>
                    <tr>
                        <?php if (auth()->user()->can('standarpelayanan.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $standarpelayanan->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Umum\StandarPelayanan\Views\_row_info', ['standarpelayanan' => $standarpelayanan]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('standarpelayanan.delete')) : ?>
    <input type="submit" value="<?= lang('StandarPelayanan.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>