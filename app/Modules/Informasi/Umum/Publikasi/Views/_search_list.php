<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Publikasi.id'),
        'title'         => lang('Publikasi.title'),
        'excerpt'       => lang('Publikasi.excerpt'),
        'updated_at'    => lang('Publikasi.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $publikasi) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\Publikasi\Views\_row_info', ['publikasi' => $publikasi]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>