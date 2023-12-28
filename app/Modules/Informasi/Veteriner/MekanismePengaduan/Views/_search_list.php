<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('MekanismePengaduan.id'),
        'title'         => lang('MekanismePengaduan.title'),
        'excerpt'       => lang('MekanismePengaduan.excerpt'),
        'updated_at'    => lang('MekanismePengaduan.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $mekanismepengaduan) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Veteriner\MekanismePengaduan\Views\_row_info', ['mekanismepengaduan' => $mekanismepengaduan]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>