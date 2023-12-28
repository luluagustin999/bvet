<td><?= esc($blog->id) ?></td>
<td><?= esc($blog->title) ?></td>
<td><?= esc($blog->excerpt) ?></td>
<td><?= esc($blog->updated_at) ?></td>
<td class="justify-content-end">
    <?php if (auth()->user()->can('blogs.edit') || auth()->user()->can('blogs.delete')) : ?>
        <!-- Action Menu -->
        <div class="dropdown">
            <button class="btn btn-default btn-sm dropdown-toggle btn-3-dots" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu">
                <?php if (auth()->user()->can('blogs.edit')) : ?>
                    <li><a href="<?= url_to('blog-edit', $blog->id) ?>" class="dropdown-item"><?= lang('Bonfire.edit') ?></a></li>
                <?php endif ?>
                <?php if (auth()->user()->can('blogs.delete')) : ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a href="<?= url_to('blog-delete', $blog->id) ?>" class="dropdown-item" onclick="return confirm(<?= lang('Bonfire.deleteResource', [lang('Blogs.blog')]) ?>)">
                            <?= lang('Bonfire.delete') ?>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>
</td>