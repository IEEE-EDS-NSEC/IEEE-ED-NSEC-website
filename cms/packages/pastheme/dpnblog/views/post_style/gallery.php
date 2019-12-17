<?php if ($post->isPostStyle() == 'Image Gallery' && !empty($post->data['gallery'][0]['image'])): ?>
    <div class="uk-slidenav-position" data-uk-slideshow="{autoplay:true}">
        <ul class="uk-slideshow" >
            <?php foreach ($post->data['gallery'] as $gallery): ?>
                <li><img src="<?= $gallery['image'] ?>" alt="<?= $post->title ?>"></li>
            <?php endforeach; ?>
        </ul>
        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
    </div>
<?php endif; ?>
<h1 class="uk-margin"><?= $post->title ?></h1>
