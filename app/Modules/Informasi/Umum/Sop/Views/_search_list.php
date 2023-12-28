<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Sop.id'),
        'title'         => lang('Sop.title'),
        'excerpt'       => lang('Sop.excerpt'),
        'updated_at'    => lang('Sop.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $sop) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\Sop\Views\_row_info', ['sop' => $sop]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>