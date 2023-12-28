<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Pelayanan.id'),
        'title'         => lang('Pelayanan.title'),
        'excerpt'       => lang('Pelayanan.excerpt'),
        'updated_at'    => lang('Pelayanan.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $pelayanan) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\Pelayanan\Views\_row_info', ['pelayanan' => $pelayanan]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>