<?php if ($tags): ?>
    <ul class="uk-grid uk-grid-small uk-text-small">
        <?php foreach ($tags as $tag): ?>
            <li>
                <a href="<?= $view->url('@dpnblog/tags/id' , ['id' => $tag->id ]) ?>"><?= $tag->tags ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <?= __('Tags Not Found') ?>
<?php endif; ?>
