<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($aplikasi) && count($aplikasi)) : ?>
                <?php foreach ($aplikasi as $aplikasi) : ?>
                    <tr>
                        <?php if (auth()->user()->can('aplikasi.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $aplikasi->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Aplikasi\Views\_row_info', ['aplikasi' => $aplikasi]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('aplikasi.delete')) : ?>
    <input type="submit" value="<?= lang('Aplikasi.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>