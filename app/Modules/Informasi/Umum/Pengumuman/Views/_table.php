<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($pengumuman) && count($pengumuman)) : ?>
                <?php foreach ($pengumuman as $pengumuman) : ?>
                    <tr>
                        <?php if (auth()->user()->can('pengumuman.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $pengumuman->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Umum\Pengumuman\Views\_row_info', ['pengumuman' => $pengumuman]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('pengumuman.delete')) : ?>
    <input type="submit" value="<?= lang('Pengumuman.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>