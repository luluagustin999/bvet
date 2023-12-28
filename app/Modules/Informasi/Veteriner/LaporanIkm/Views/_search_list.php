<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('LaporanIkm.id'),
        'title'         => lang('LaporanIkm.title'),
        'excerpt'       => lang('LaporanIkm.excerpt'),
        'updated_at'    => lang('LaporanIkm.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $laporanikm) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Veteriner\LaporanIkm\Views\_row_info', ['laporanikm' => $laporanikm]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>