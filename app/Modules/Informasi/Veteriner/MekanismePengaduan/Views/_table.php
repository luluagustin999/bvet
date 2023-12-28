<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($mekanismepengaduan) && count($mekanismepengaduan)) : ?>
                <?php foreach ($mekanismepengaduan as $mekanismepengaduan) : ?>
                    <tr>
                        <?php if (auth()->user()->can('mekanismepengaduan.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $mekanismepengaduan->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Veteriner\MekanismePengaduan\Views\_row_info', ['mekanismepengaduan' => $mekanismepengaduan]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('mekanismepengaduan.delete')) : ?>
    <input type="submit" value="<?= lang('MekanismePengaduan.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>