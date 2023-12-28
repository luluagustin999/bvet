<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Aplikasi.id'),
        'title'         => lang('Aplikasi.title'),
        'excerpt'       => lang('Aplikasi.excerpt'),
        'updated_at'    => lang('Aplikasi.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $aplikasi) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Aplikasi\Views\_row_info', ['aplikasi' => $aplikasi]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>