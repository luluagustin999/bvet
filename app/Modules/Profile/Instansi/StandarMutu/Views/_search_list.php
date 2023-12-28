<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('StandarMutu.id'),
        'title'         => lang('StandarMutu.title'),
        'excerpt'       => lang('StandarMutu.excerpt'),
        'updated_at'    => lang('StandarMutu.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $standarmutu) : ?>
            <tr>
                <?= view('App\Modules\Profile\Instansi\StandarMutu\Views\_row_info', ['standarmutu' => $standarmutu]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>