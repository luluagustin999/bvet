<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Galleries.id'),
        'title'         => lang('Galleries.title'),
        'excerpt'       => lang('Galleries.excerpt'),
        'updated_at'    => lang('Galleries.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $gallery) : ?>
            <tr>
                <?= view('App\Modules\Galleries\Views\_row_info', ['gallery' => $gallery]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>