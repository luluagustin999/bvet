<table class="table table-hover">
    <?= $this->setData(['headers' => [
        'id'            => lang('Agenda.id'),
        'title'         => lang('Agenda.title'),
        'excerpt'       => lang('Agenda.excerpt'),
        'updated_at'    => lang('Agenda.updated')
    ]])->include('_table_head') ?>
    <tbody>
        <?php foreach ($rows as $agenda) : ?>
            <tr>
                <?= view('App\Modules\Informasi\Umum\Agenda\Views\_row_info', ['agenda' => $agenda]) ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>