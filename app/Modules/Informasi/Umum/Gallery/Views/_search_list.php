<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Gallery.id'),
        'title'         => lang('Gallery.title'),
        'excerpt'       => lang('Gallery.excerpt'),
        'updated_at'    => lang('Gallery.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $gallery) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\Gallery\Views\_row_info', ['gallery' => $gallery]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>