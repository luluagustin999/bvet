<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Berita.id'),
        'title'         => lang('Berita.title'),
        'excerpt'       => lang('Berita.excerpt'),
        'updated_at'    => lang('Berita.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $berita) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\Berita\Views\_row_info', ['berita' => $berita]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>