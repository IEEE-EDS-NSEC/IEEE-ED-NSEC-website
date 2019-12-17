<template lang="html">

    <div class="uk-grid pk-grid-large" data-uk-grid-margin>

        <div class="uk-form pk-width-content uk-grid-margin">

            <div class="uk-form-row">
                <div class="uk-form-controls">
                    <input type="text" class="uk-form-large uk-width-1-1" :placeholder="'Title' | trans" v-model="post.title" required>
                </div>
            </div>

            <div class="uk-form-row">
                <label class="uk-form-label">{{'Excerpt' | trans}}</label>
                <div class="uk-form-controls">
                    <v-editor id="post-content" :value.sync="post.excerpt" :options="{markdown : post.data.markdown , height:100}"></v-editor>
                </div>
            </div>

            <div class="uk-form-row">
                <label class="uk-form-label">{{'Content' | trans}}</label>
                <div class="uk-form-controls">
                    <v-editor id="post-content" :value.sync="post.content" :options="{markdown : post.data.markdown}"></v-editor>
                </div>
            </div>

        </div>

        <div class="pk-width-sidebar">

            <div class="uk-panel uk-panel-box uk-panel-box-muted">
                <div class="uk-panel-title">
                    <h3>{{'Post Style' | trans}}</h3>
                </div>
                <div class="uk-form-row">
                    <div class="uk-form-controls">
                        <p class="uk-margin-small">
                            <label><input type="radio" v-model="post.post_style" value="0"> <i class="uk-icon-file"></i> {{'Default' | trans}}</label>
                        </p>
                        <p class="uk-margin-small">
                            <label><input type="radio" v-model="post.post_style" value="1"> <i class="uk-icon-youtube-play"></i> {{'Video' | trans}}</label>
                        </p>
                        <p class="uk-margin-small">
                            <label><input type="radio" v-model="post.post_style" value="2"> <i class="uk-icon-list-alt"></i> {{'Article' | trans}}</label>
                        </p>
                        <p class="uk-margin-small">
                            <label><input type="radio" v-model="post.post_style" value="3"> <i class="uk-icon-image"></i> {{'Gallery' | trans}}</label>
                        </p>
                        <p class="uk-margin-small">
                            <label><input type="radio" v-model="post.post_style" value="4"> <i class="uk-icon-mortar-board"></i> {{'Document' | trans}}</label>
                        </p>
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <blog-image :post.sync="post" v-if="
                post.post_style == 0 ||
                post.post_style == 2 ||
                post.post_style == 4
                "></blog-image>
            </div>

            <div class="uk-margin">
                <blog-video :post.sync="post" v-if="post.post_style == 1"></blog-video>
            </div>

            <div class="uk-margin">
                <blog-gallery :post.sync="post" v-if="post.post_style == 3"></blog-gallery>
            </div>

            <div class="uk-form-row">
                <label for="form-slug" class="uk-form-label">{{ 'Slug' | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-slug" class="uk-width-1-1" type="text" v-model="post.slug">
                </div>
            </div>

            <div class="uk-form-row">
                <label class="uk-form-label">{{ 'Categories' | trans}}</label>
                <div class="uk-form-controls">
                    <select class="uk-width-1-1" v-model="post.category_id">
                        <option v-for="category in categories" v-bind:value="category.id">
                            {{category.title}}
                        </option>
                    </select>
                </div>
            </div>

            <div class="uk-form-row">
                <div>
                    <input-tags :post.sync="post.tags" :tags.sync="tags"></input-tags>
                </div>
            </div>

            <div class="uk-form-row">
                <label for="form-status" class="uk-form-label">{{ 'Status' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-status" class="uk-width-1-1" v-model="post.status">
                        <option v-for="(id, status) in data.statuses" :value="id">{{status}}</option>
                    </select>
                </div>
            </div>

            <div class="uk-form-row">
                <label for="form-author" class="uk-form-label">{{ 'Author' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-author" class="uk-width-1-1" v-model="post.user_id">
                        <option v-for="author in data.authors" :value="author.id">{{author.username}}</option>
                    </select>
                </div>
            </div>

            <div class="uk-form-row">
                <span class="uk-form-label">{{ 'Publish on' | trans }}</span>
                <div class="uk-form-controls">
                    <input-date :datetime.sync="post.date"></input-date>
                </div>
            </div>

            <div class="uk-form-row">
                <span class="uk-form-label">{{ 'Restrict Access' | trans }}</span>
                <div class="uk-form-controls uk-form-controls-text">
                    <p v-for="role in data.roles" class="uk-form-controls-condensed">
                        <label><input type="checkbox" :value="role.id" v-model="post.roles" number> {{ role.name }}</label>
                    </p>
                </div>
            </div>
            <div class="uk-form-row">
                <span class="uk-form-label">{{ 'Options' | trans }}</span>
                <div class="uk-form-controls">
                    <label><input type="checkbox" v-model="post.data.markdown" value="1"> {{ 'Enable Markdown' | trans }}</label>
                </div>
                <div class="uk-form-controls">
                    <label><input type="checkbox" v-model="post.comment_status" value="1"> {{ 'Enable Comments' | trans }}</label>
                </div>
            </div>

        </div>

    </div>

</template>

<script>

export default {

    props:['post' , 'data' , 'form'],

    section:{
        label:'Post',
        priority:0
    },

    data:function(){
        return {
            categories:'',
            tags:[],
        }
    },

    ready:function(){
        this.getCategories();
        this.getTags();
    },

    methods:{

        goodies:function(){
            $('#goodies-tag').tagEditor({
                initialTags: this.post.tags,
                autocomplete: {
                    delay:0,
                    source: this.tags
                },
                forceLowercase: true,
                placeholder: 'Enter tags ...'
            });
        },

        getTags:function(){
            this.$http.get('admin/apidpnblog/tags/getalltags').then( res => {
                this.tags = res.data.data;
            });
        },

        getCategories:function(){
            this.$http.get('admin/apidpnblog/post/get-categories').then(res => {
                if (res.data.status == 200) {
                    this.categories = res.data.data;
                    UIkit.notify(res.data.msg , 'primary');
                }else {
                    UIkit.notify(res.data.msg);
                }
            });
        },
    },

    components:{
        blogImage:require('../../../components/admin/post-edit/post-style/image.vue'),
        blogVideo:require('../../../components/admin/post-edit/post-style/video.vue'),
        blogGallery: require('../../../components/admin/post-edit/post-style/gallery.vue'),
        inputTags: require('../../../module/input-tags.vue')
    }

}
</script>
