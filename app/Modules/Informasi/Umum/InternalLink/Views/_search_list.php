<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('InternalLink.id'),
        'title'         => lang('InternalLink.title'),
        'excerpt'       => lang('InternalLink.excerpt'),
        'updated_at'    => lang('InternalLink.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $internallink) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\InternalLink\Views\_row_info', ['internallink' => $internallink]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>