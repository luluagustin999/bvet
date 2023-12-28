<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($tarifpengujian) && count($tarifpengujian)) : ?>
                <?php foreach ($tarifpengujian as $tarifpengujian) : ?>
                    <tr>
                        <?php if (auth()->user()->can('tarifpengujian.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $tarifpengujian->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Veteriner\TarifPengujian\Views\_row_info', ['tarifpengujian' => $tarifpengujian]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('tarifpengujian.delete')) : ?>
    <input type="submit" value="<?= lang('TarifPengujian.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>