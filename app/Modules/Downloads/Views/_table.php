<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($downloads) && count($downloads)) : ?>
                <?php foreach ($downloads as $download) : ?>
                    <tr>
                        <?php if (auth()->user()->can('downloads.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $download->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Downloads\Views\_row_info', ['download' => $download]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('downloads.delete')) : ?>
    <input type="submit" value="<?= lang('Downloads.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>