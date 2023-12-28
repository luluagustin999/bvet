<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Pengumuman.id'),
        'title'         => lang('Pengumuman.title'),
        'excerpt'       => lang('Pengumuman.excerpt'),
        'updated_at'    => lang('Pengumuman.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $pengumuman) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\Pengumuman\Views\_row_info', ['pengumuman' => $pengumuman]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>