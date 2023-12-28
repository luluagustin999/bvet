<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('TarifPengujian.id'),
        'title'         => lang('TarifPengujian.title'),
        'excerpt'       => lang('TarifPengujian.excerpt'),
        'updated_at'    => lang('TarifPengujian.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $tarifpengujian) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Veteriner\TarifPengujian\Views\_row_info', ['tarifpengujian' => $tarifpengujian]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>