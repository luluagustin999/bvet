<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('RencanaKerja.id'),
        'title'         => lang('RencanaKerja.title'),
        'excerpt'       => lang('RencanaKerja.excerpt'),
        'updated_at'    => lang('RencanaKerja.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $rencanakerja) : ?>
            <tr>
                <?= view('App\Modules\Program\RencanaKerja\Views\_row_info', ['rencanakerja' => $rencanakerja]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>