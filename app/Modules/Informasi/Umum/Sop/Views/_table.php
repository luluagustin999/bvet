<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($sop) && count($sop)) : ?>
                <?php foreach ($sop as $sop) : ?>
                    <tr>
                        <?php if (auth()->user()->can('sop.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $sop->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Umum\Sop\Views\_row_info', ['sop' => $sop]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('sop.delete')) : ?>
    <input type="submit" value="<?= lang('Sop.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>