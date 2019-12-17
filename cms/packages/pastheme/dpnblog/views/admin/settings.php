<?= $view->style('dpnblog-admin-css' , 'dpnblog:assets/css/dpnblog-admin.css' , 'theme') ?>
<?= $view->script('dpnblog-settings' , 'dpnblog:app/bundle/admin-settings.js' , 'vue') ?>
<div>
    <div class="uk-cover-background uk-position-relative">
        <img class="dpnblog-wallpaper-image" src="<?= $view->url()->getStatic('dpnblog:assets/image/banner.svg') ?>">
        <div class="uk-position-absolute uk-flex uk-flex-left uk-flex-bottom" style="bottom:20px;left:20px;">
            <ul class="uk-text-small uk-text-muted uk-grid uk-grid-small">
                <li><a href="<?= $package->authors[0]->homepage ?>" target="_blank"><?= $package->authors[0]->name ?></a></li>
                <li><a href="<?= $package->repository ?>" target="_blank"><i class="uk-icon-github"></i> <?= __('Project') ?></a></li>
                <li><?= __('Version') ?>: <?= $package->version ?></li>
                <li><?= __('License') ?>: <?= $package->license ?></li>
                <li><a href="#readmeModel" data-uk-modal><?= __('Readme') ?></a></li>
                <li><a href="#changelogModel" data-uk-modal><?= __('Changelog') ?></a></li>
            </ul>
        </div>
    </div>

    <div id="readmeModel" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <a class="uk-modal-close uk-close"></a>
            <?= $content['readme'] ?>
        </div>
    </div>
    <div id="changelogModel" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <?= $content['changelog'] ?>
        </div>
    </div>

    <div id="settings" class="uk-margin uk-form">
        <div data-uk-margin>
            <button class="uk-button uk-button-primary uk-align-right" @click.prevent="save">{{ 'Save' | trans }}</button>
        </div>

        <div class="uk-form-row">
            <span class="uk-form-label">{{ 'Permalink' | trans }}</span>
            <div class="uk-form-controls uk-form-controls-text">
                <p class="uk-form-controls-condensed">
                    <label>
                        <input type="radio" v-model="config.permalink.type" value="">
                        {{ 'Numeric' | trans }} <code>{{ '/123' | trans }}</code>
                    </label>
                </p>
                <p class="uk-form-controls-condensed">
                    <label>
                        <input type="radio" v-model="config.permalink.type" value="{slug}">
                        {{ 'Name' | trans }} <code>{{ '/sample-post' | trans }}</code>
                    </label>
                </p>
                <p class="uk-form-controls-condensed">
                    <label>
                        <input type="radio" v-model="config.permalink.type" value="{year}/{month}/{day}/{slug}">
                        {{ 'Day and name' | trans }} <code>{{ '/2014/06/12/sample-post' | trans }}</code>
                    </label>
                </p>
                <p class="uk-form-controls-condensed">
                    <label>
                        <input type="radio" v-model="config.permalink.type" value="{year}/{month}/{slug}">
                        {{ 'Month and name' | trans }} <code>{{ '/2014/06/sample-post' | trans }}</code>
                    </label>
                </p>
                <p class="uk-form-controls-condensed">
                    <label>
                        <input type="radio" v-model="config.permalink.type" value="custom">
                        {{ 'Custom' | trans }}
                    </label>
                    <input class="uk-form-small" type="text" v-model="config.permalink.custom">
                </p>
            </div>
        </div>

        <div class="uk-form-row">
            <label class="uk-form-label">{{ 'Posts per page' | trans }}</label>
            <div class="uk-form-controls uk-form-controls-text">
                <p class="uk-form-controls-condensed">
                    <input type="number" v-model="config.posts.posts_per_page" class="uk-form-width-small">
                </p>
            </div>
        </div>

        <div class="uk-form-row">
            <span class="uk-form-label">{{ 'Default post settings' | trans }}</span>
            <div class="uk-form-controls uk-form-controls-text">
                <p class="uk-form-controls-condensed">
                    <label><input type="checkbox" v-model="config.posts.markdown_enabled"> {{ 'Enable Markdown' | trans }}</label>
                </p>
            </div>
        </div>

        <div class="uk-form-row">
            <span class="uk-form-label">{{ 'Show of Author Box' | trans }}</span>
            <div class="uk-form-controls uk-form-controls-text">
                <p class="uk-form-controls-condensed">
                    <label><input type="checkbox" v-model="config.posts.author_box_show"> {{ 'Enable Author Box' | trans }}</label>
                </p>
            </div>
        </div>

    </div>

</div>
