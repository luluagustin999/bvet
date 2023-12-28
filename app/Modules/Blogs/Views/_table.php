<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($blogs) && count($blogs)) : ?>
                <?php foreach ($blogs as $blog) : ?>
                    <tr>
                        <?php if (auth()->user()->can('blogs.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $blog->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Blogs\Views\_row_info', ['blog' => $blog]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('blogs.delete')) : ?>
    <input type="submit" value="<?= lang('Blogs.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>