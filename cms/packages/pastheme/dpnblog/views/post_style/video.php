<article class="uk-margin uk-text-center">
    <h1 class="uk-margin-small-bottom"><?= $post->title ?></h1>
</article>
<?php if ($post->isPostStyle() == 'Video Content' && !empty($post->data['video']['source'])): ?>
    <video controls class="uk-responsive-width uk-width-1-1">
        <source type="video/mp4" src="<?= $view->url()->get($post->data['video']['source']) ?>">
    </video>
<?php endif; ?>
