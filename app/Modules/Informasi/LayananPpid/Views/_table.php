<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($layananppid) && count($layananppid)) : ?>
                <?php foreach ($layananppid as $layananppid) : ?>
                    <tr>
                        <?php if (auth()->user()->can('layananppid.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $layananppid->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\LayananPpid\Views\_row_info', ['layananppid' => $layananppid]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('layananppid.delete')) : ?>
    <input type="submit" value="<?= lang('LayananPpid.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>