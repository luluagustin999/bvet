<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($publikasi) && count($publikasi)) : ?>
                <?php foreach ($publikasi as $publikasi) : ?>
                    <tr>
                        <?php if (auth()->user()->can('publikasi.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $publikasi->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Umum\Publikasi\Views\_row_info', ['publikasi' => $publikasi]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('publikasi.delete')) : ?>
    <input type="submit" value="<?= lang('Publikasi.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>