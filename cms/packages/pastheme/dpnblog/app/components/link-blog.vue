<template lang="html">
    <div class="uk-margin" data-uk-margin>

        <div class="uk-form-row">
            <select class="uk-width-1-1" v-model="link">
                <option value="post">{{ 'Posts View' | trans }}</option>
                <optgroup :label="'Categories' | trans">
                    <option v-for="category in categories" :value="category | link">{{ category.title }}</option>
                </optgroup>
            </select>
        </div>

    </div>
</template>

<script>
module.exports = {
    props: ['link'],
    link: {
        label: 'Advanced Blog'
    },

    data: function () {
        return {
            posts: [],
            categories:[]
        }
    },

    ready: function() {
        this.link = '@dpnblog';
        this.getCategories();
    },

    filters: {
        link: function (category) {
            return '@dpnblog/category/id?id='+category.id;
        }
    },

    methods:{
        getCategories:function(){
            this.$http.get('admin/apidpnblog/post/get-categories').then( res => {
                if (res.data.status == 200 ) {
                    this.categories = res.data.data;
                }
            } )
        }
    }

}
window.Links.components['link-blog'] = module.exports;
</script>
