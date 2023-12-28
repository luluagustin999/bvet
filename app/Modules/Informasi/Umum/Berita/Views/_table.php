<div class="table-responsive">
    <table class="table table-hover">
        <?= $this->include('_table_head') ?>
        <tbody>
            <?php if (isset($berita) && count($berita)) : ?>
                <?php foreach ($berita as $berita) : ?>
                    <tr>
                        <?php if (auth()->user()->can('berita.delete')) : ?>
                            <td>
                                <input type="checkbox" name="selects[<?= $berita->id ?>]" class="form-check">
                            </td>
                        <?php endif ?>
                        <?= view('App\Modules\Informasi\Umum\Berita\Views\_row_info', ['berita' => $berita]) ?>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php if (auth()->user()->can('berita.delete')) : ?>
    <input type="submit" value="<?= lang('Berita.deleteSelected') ?>" class="btn btn-sm btn-outline-danger" />
<?php endif ?>

<div class="text-center">
    <?= $pager->links('default', 'bonfire_full') ?>
</div>