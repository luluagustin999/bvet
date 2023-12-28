<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Anggaran.id'),
        'title'         => lang('Anggaran.title'),
        'excerpt'       => lang('Anggaran.excerpt'),
        'updated_at'    => lang('Anggaran.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $anggaran) : ?>
            <tr>
                <?= view('App\Modules\Program\Anggaran\Views\_row_info', ['anggaran' => $anggaran]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>