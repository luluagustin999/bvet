<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('InformasiSerta.id'),
        'title'         => lang('InformasiSerta.title'),
        'excerpt'       => lang('InformasiSerta.excerpt'),
        'updated_at'    => lang('InformasiSerta.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $informasiserta) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Veteriner\InformasiSerta\Views\_row_info', ['informasiserta' => $informasiserta]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>