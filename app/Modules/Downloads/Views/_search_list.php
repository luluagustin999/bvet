<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Downloads.id'),
        'title'         => lang('Downloads.title'),
        'excerpt'       => lang('Downloads.excerpt'),
        'updated_at'    => lang('Downloads.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $download) : ?>
            <tr>
                <?= view('App\Modules\Downloads\Views\_row_info', ['download' => $download]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>