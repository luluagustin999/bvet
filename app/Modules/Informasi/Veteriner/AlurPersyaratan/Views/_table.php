<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($alurpersyaratan) && count($alurpersyaratan)) : ?>
                <?php foreach ($alurpersyaratan as $alurpersyaratan) : ?>
                    <tr>
                        <?php if (auth()->user()->can('alurpersyaratan.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $alurpersyaratan->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Veteriner\AlurPersyaratan\Views\_row_info', ['alurpersyaratan' => $alurpersyaratan]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('alurpersyaratan.delete')) : ?>
    <input type="submit" value="<?= lang('AlurPersyaratan.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>