<template lang="html">
    <a class="uk-placeholder uk-text-center uk-display-block uk-margin-remove" @click.prevent="pick">
        <img width="105" height="105" :alt="'Placeholder Video' | trans" :src="$url('packages/pastheme/dpnblog/assets/image/gallery.svg')">
        <p class="uk-text-muted uk-margin-small-top">{{ 'Add Gallery'| trans }}</p>
    </a>

    <v-modal v-ref:modal large>
        <div class="uk-clearfix">
            <button class="uk-button uk-button-primary uk-align-right" @click.prevent="field">{{ 'New Field' | trans }}</button>
        </div>

        <div class="uk-margin">
            <div class="uk-margin-small" v-for="(indis , fieldGallery) in post.data.gallery">
                <input-image :source.sync="fieldGallery.image" class="pk-image-max-height uk-width-1-1"></input-image>
                <button class="uk-button uk-button-text" @click.prevent="remove(indis)">{{ 'Remove Field'  | trans }}</button>
            </div>
        </div>
    </v-modal>

</template>

<script>
export default {
    props: ['post'],

    methods:{
        pick:function(){
            this.$refs.modal.open();
        },

        field:function(){
            this.post.data.gallery.push({
                image:'',
            })
        },

        remove:function(indis){
            this.post.data.gallery.splice(indis , 1);
        }
    }
}
</script>
