<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Blogs.id'),
        'title'         => lang('Blogs.title'),
        'excerpt'       => lang('Blogs.excerpt'),
        'updated_at'    => lang('Blogs.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $blog) : ?>
            <tr>
                <?= view('App\Modules\Blogs\Views\_row_info', ['blog' => $blog]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>