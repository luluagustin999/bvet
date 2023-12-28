<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($tatacara) && count($tatacara)) : ?>
                <?php foreach ($tatacara as $tatacara) : ?>
                    <tr>
                        <?php if (auth()->user()->can('tatacara.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $tatacara->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Veteriner\TataCara\Views\_row_info', ['tatacara' => $tatacara]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('tatacara.delete')) : ?>
    <input type="submit" value="<?= lang('TataCara.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>