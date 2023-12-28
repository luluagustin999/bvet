<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($informasisetiap) && count($informasisetiap)) : ?>
                <?php foreach ($informasisetiap as $informasisetiap) : ?>
                    <tr>
                        <?php if (auth()->user()->can('informasisetiap.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $informasisetiap->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Veteriner\InformasiSetiap\Views\_row_info', ['informasisetiap' => $informasisetiap]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('informasisetiap.delete')) : ?>
    <input type="submit" value="<?= lang('InformasiSetiap.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>