<template lang="html">
    <a class="uk-placeholder uk-text-center uk-display-block uk-margin-remove" v-if="!post.data.video.source" @click.prevent="pick">
        <img width="60" height="60" :alt="'Placeholder Video' | trans" :src="$url('app/system/assets/images/placeholder-video.svg')">
        <p class="uk-text-muted uk-margin-small-top">{{ 'Add Video'| trans }}</p>
    </a>

    <div class="uk-overlay uk-overlay-hover uk-visible-hover" v-if="post.data.video.source">

        <img :src="$url(post.data.video.image)" v-if="post.data.video.image">

        <video controls class="uk-responsive-width uk-width-1-1" v-if="!post.data.video.image">
            <source :src="$url(post.data.video.source)" type="video/mp4">
        </video>
        <div class="uk-overlay-panel uk-overlay-background uk-overlay-fade"></div>

        <a class="uk-position-cover" @click.prevent="pick"></a>

        <div class="uk-panel-badge pk-panel-badge uk-hidden">
            <ul class="uk-subnav pk-subnav-icon">
                <li><a class="pk-icon-delete pk-icon-hover" :title="'Delete' | trans" data-uk-tooltip="{delay: 500}" @click.prevent="remove"></a></li>
            </ul>
        </div>
    </div>

    <v-modal v-ref:modal>
        <form class="uk-form uk-form-stacked" @submit="update">

            <div class="uk-modal-header">
                <h2 class="uk-text-capitalize">{{ 'Video' | trans }}</h2>
            </div>

            <div class="uk-form-row">
                <input-image :source.sync="post.data.video.image" class="pk-image-max-height"></input-image>
            </div>

            <div class="uk-form-row">
                <a class="uk-placeholder uk-text-center uk-display-block uk-margin-remove" v-if="!post.data.video.source" @click.prevent="video">
                    <img width="60" height="60" :alt="'Placeholder Video' | trans" :src="$url('app/system/assets/images/placeholder-video.svg')">
                    <p class="uk-text-muted uk-margin-small-top">{{ 'Add Video'| trans }}</p>
                </a>
            </div>

            <div class="uk-overlay uk-overlay-hover uk-visible-hover" v-if="post.data.video.source">
                <video controls class="uk-responsive-width uk-width-1-1">
                    <source :src="$url(post.data.video.source)" type="video/mp4">
                </video>
                <div class="uk-overlay-panel uk-overlay-background uk-overlay-fade"></div>

                <a class="uk-position-cover" @click.prevent="pick"></a>

                <div class="uk-panel-badge pk-panel-badge uk-hidden">
                    <ul class="uk-subnav pk-subnav-icon">
                        <li><a class="pk-icon-delete pk-icon-hover" :title="'Delete' | trans" data-uk-tooltip="{delay: 500}" @click.prevent="remove"></a></li>
                    </ul>
                </div>
            </div>

            <v-modal v-ref:video large>
                <panel-finder :root="storage" :modal="true" v-ref:finder></panel-finder>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-link uk-modal-close" type="button">{{ 'Cancel' | trans }}</button>
                    <button class="uk-button uk-button-primary" type="button" :disabled="!selectButton" @click.prevent="select">{{ 'Select' | trans }}</button>
                </div>
            </v-modal>

            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-link uk-modal-close" type="button">{{ 'Complete' | trans }}</button>
           </div>

        </form>
   </v-modal>

</template>

<script>
export default {
    props:['post'],

    data:function(){
        return _.merge({source: ''}, $pagekit);
    },

    computed: {
        selectButton: function () {
            var selected = this.$refs.finder.getSelected();
            return selected.length === 1 && this.$refs.finder.isVideo(selected[0])
        }
    },

    methods:{
        pick:function(){
            this.$refs.modal.open();
        },

        video: function(){
            this.$refs.video.open();
        },

        select: function () {
            this.post.data.video.source = this.$refs.finder.getSelected()[0];
            this.$refs.video.close();
        },

        remove: function(){
            this.post.data.video.source = ''
        }

    }
}
</script>
