<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($kinerja) && count($kinerja)) : ?>
                <?php foreach ($kinerja as $kinerja) : ?>
                    <tr>
                        <?php if (auth()->user()->can('kinerja.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $kinerja->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Kinerja\Views\_row_info', ['kinerja' => $kinerja]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('kinerja.delete')) : ?>
    <input type="submit" value="<?= lang('Kinerja.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>