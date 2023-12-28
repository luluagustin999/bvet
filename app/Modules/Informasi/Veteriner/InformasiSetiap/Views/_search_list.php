<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('InformasiSetiap.id'),
        'title'         => lang('InformasiSetiap.title'),
        'excerpt'       => lang('InformasiSetiap.excerpt'),
        'updated_at'    => lang('InformasiSetiap.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $informasisetiap) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Veteriner\InformasiSetiap\Views\_row_info', ['informasisetiap' => $informasisetiap]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>