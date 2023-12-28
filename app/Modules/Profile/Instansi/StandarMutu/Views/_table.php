<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($standarmutu) && count($standarmutu)) : ?>
                <?php foreach ($standarmutu as $standarmutu) : ?>
                    <tr>
                        <?php if (auth()->user()->can('standarmutu.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $standarmutu->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Profile\Instansi\StandarMutu\Views\_row_info', ['standarmutu' => $standarmutu]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('standarmutu.delete')) : ?>
    <input type="submit" value="<?= lang('StandarMutu.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>