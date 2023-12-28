<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('AlurPersyaratan.id'),
        'title'         => lang('AlurPersyaratan.title'),
        'excerpt'       => lang('AlurPersyaratan.excerpt'),
        'updated_at'    => lang('AlurPersyaratan.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $alurpersyaratan) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Veteriner\AlurPersyaratan\Views\_row_info', ['alurpersyaratan' => $alurpersyaratan]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>