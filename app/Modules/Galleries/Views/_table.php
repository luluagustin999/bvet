<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($galleries) && count($galleries)) : ?>
                <?php foreach ($galleries as $gallery) : ?>
                    <tr>
                        <?php if (auth()->user()->can('galleries.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $gallery->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Galleries\Views\_row_info', ['gallery' => $gallery]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('galleries.delete')) : ?>
    <input type="submit" value="<?= lang('Galleries.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>