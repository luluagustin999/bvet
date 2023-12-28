<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('StandarPelayanan.id'),
        'title'         => lang('StandarPelayanan.title'),
        'excerpt'       => lang('StandarPelayanan.excerpt'),
        'updated_at'    => lang('StandarPelayanan.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $standarpelayanan) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\StandarPelayanan\Views\_row_info', ['standarpelayanan' => $standarpelayanan]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>