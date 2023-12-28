<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('SertifikatHasil.id'),
        'title'         => lang('SertifikatHasil.title'),
        'excerpt'       => lang('SertifikatHasil.excerpt'),
        'updated_at'    => lang('SertifikatHasil.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $sertifikathasil) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Veteriner\SertifikatHasil\Views\_row_info', ['sertifikathasil' => $sertifikathasil]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>