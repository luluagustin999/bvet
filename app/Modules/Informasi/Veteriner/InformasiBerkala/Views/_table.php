<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($informasiberkala) && count($informasiberkala)) : ?>
                <?php foreach ($informasiberkala as $informasiberkala) : ?>
                    <tr>
                        <?php if (auth()->user()->can('informasiberkala.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $informasiberkala->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Veteriner\InformasiBerkala\Views\_row_info', ['informasiberkala' => $informasiberkala]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('informasiberkala.delete')) : ?>
    <input type="submit" value="<?= lang('InformasiBerkala.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>