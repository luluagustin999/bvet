<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('LayananPpid.id'),
        'title'         => lang('LayananPpid.title'),
        'excerpt'       => lang('LayananPpid.excerpt'),
        'updated_at'    => lang('LayananPpid.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $layananppid) : ?>
            <tr>
                <?= view('App\Modules\Informasi\LayananPpid\Views\_row_info', ['layananppid' => $layananppid]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>