<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('ExternalLink.id'),
        'title'         => lang('ExternalLink.title'),
        'excerpt'       => lang('ExternalLink.excerpt'),
        'updated_at'    => lang('ExternalLink.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $externallink) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\ExternalLink\Views\_row_info', ['externallink' => $externallink]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>