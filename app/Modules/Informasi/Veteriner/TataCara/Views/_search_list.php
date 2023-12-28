<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('TataCara.id'),
        'title'         => lang('TataCara.title'),
        'excerpt'       => lang('TataCara.excerpt'),
        'updated_at'    => lang('TataCara.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $tatacara) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Veteriner\TataCara\Views\_row_info', ['tatacara' => $tatacara]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>