<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Kinerja.id'),
        'title'         => lang('Kinerja.title'),
        'excerpt'       => lang('Kinerja.excerpt'),
        'updated_at'    => lang('Kinerja.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $kinerja) : ?>
            <tr>
                <?= view('App\Modules\Kinerja\Views\_row_info', ['kinerja' => $kinerja]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>