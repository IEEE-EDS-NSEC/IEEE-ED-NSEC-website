<?= $view->style('dpnblog-admin-css' , 'dpnblog:assets/css/dpnblog-admin.css' , 'theme') ?>
<?= $view->script('admin-post-edit' , 'dpnblog:app/bundle/admin-post-edit.js' , ['vue', 'editor', 'uikit']) ?>
<form id="post" class="uk-form" @submit.prevent="save" v-cloak>

    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
        <div data-uk-margin>

            <h2 class="uk-margin-remove" v-if="data.post.id">{{ 'Edit Post' | trans }}</h2>
            <h2 class="uk-margin-remove" v-else>{{ 'Add Post' | trans }}</h2>

        </div>
        <div data-uk-margin>

            <a class="uk-button uk-margin-small-right" :href="$url.route('admin/dpnblog/posts')">{{ data.post.id ? 'Close' : 'Cancel' | trans }}</a>
            <button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

        </div>
    </div>

    <ul class="uk-tab" v-el:tab v-show="sections.length > 1">
        <li v-for="section in sections"><a>{{ section.label | trans }}</a></li>
    </ul>

    <div class="uk-switcher uk-margin" v-el:content>
        <div v-for="section in sections">
            <component :is="section.name" :form="form" :post.sync="data.post" :data.sync="data"></component>
        </div>
    </div>

</form>
