<?= $view->style('dpnblog-admin-css', 'dpnblog:assets/css/dpnblog-admin.css', ['uikit-slideshow']) ?>
<?= $view->script('dpnblog-posts', 'dpnblog:app/bundle/dpnblog-posts.js', ['vue', 'uikit-slideshow']) ?>
<section>
    <?php
    switch ($post->post_style) {
        case 1:
            echo $view->render('dpnblog/post_style/video.php');
            break;
        case 2:
            echo $view->render('dpnblog/post_style/article.php');
            break;
        case 3:
            echo $view->render('dpnblog/post_style/gallery.php');
            break;
        case 4:
            echo $view->render('dpnblog/post_style/document.php');
            break;
        default:
            echo $view->render('dpnblog/post_style/default.php');
    }
    ?>
    <article id="posts" class="uk-margin">

        <div class="uk-comment-meta">
          <?= __('Posted in') ?>
          <a class="uk-text-bold" href="<?= $view->url('@dpnblog/category/id', ['id' => $post->category_id]) ?>"><?= $post->category->title ?></a>
          <?= __('%date%', ['%date%' => '<time datetime="' . $post->date->format(\DateTime::ATOM) . '" v-cloak>{{ "' . $post->date->format(\DateTime::ATOM) . '" | date "longDate" }}</time>']) ?>
        </div>

        <div class="uk-margin">
            <ul class="uk-subnav uk-text-small">
                <?php foreach ($post->tagsSerialize() as $tag) : ?>
                    <li><a href="<?= $view->url('@dpnblog/tags/id', ['id' => $tag->id]) ?>"><?= $tag->tags ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php if ($authorBox === true): ?>
            <div class="uk-comment uk-margin-bottom">
                <div class="uk-comment-header">
                    <img class="uk-comment-avatar" src="<?= $post->getGravatar() ?>">
                    <h4 class="uk-comment-title"><?= $user->name ?></h4>
                    <div class="uk-comment-meta">
                        <?= $user->email ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="uk-margin-small"><?= $post->content ?></div>

    </article>
</section>
