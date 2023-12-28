<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($pelayanan) && count($pelayanan)) : ?>
                <?php foreach ($pelayanan as $pelayanan) : ?>
                    <tr>
                        <?php if (auth()->user()->can('pelayanan.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $pelayanan->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Umum\Pelayanan\Views\_row_info', ['pelayanan' => $pelayanan]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('pelayanan.delete')) : ?>
    <input type="submit" value="<?= lang('Pelayanan.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>