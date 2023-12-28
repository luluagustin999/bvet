<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($gallery) && count($gallery)) : ?>
                <?php foreach ($gallery as $gallery) : ?>
                    <tr>
                        <?php if (auth()->user()->can('gallery.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $gallery->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Umum\Gallery\Views\_row_info', ['gallery' => $gallery]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('gallery.delete')) : ?>
    <input type="submit" value="<?= lang('Gallery.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>