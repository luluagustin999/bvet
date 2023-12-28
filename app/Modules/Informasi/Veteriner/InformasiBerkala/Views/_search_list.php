<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('InformasiBerkala.id'),
        'title'         => lang('InformasiBerkala.title'),
        'excerpt'       => lang('InformasiBerkala.excerpt'),
        'updated_at'    => lang('InformasiBerkala.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $informasiberkala) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Veteriner\InformasiBerkala\Views\_row_info', ['informasiberkala' => $informasiberkala]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>