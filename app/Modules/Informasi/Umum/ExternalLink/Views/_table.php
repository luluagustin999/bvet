<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($externallink) && count($externallink)) : ?>
                <?php foreach ($externallink as $externallink) : ?>
                    <tr>
                        <?php if (auth()->user()->can('externallink.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $externallink->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Umum\ExternalLink\Views\_row_info', ['externallink' => $externallink]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('externallink.delete')) : ?>
    <input type="submit" value="<?= lang('ExternalLink.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>