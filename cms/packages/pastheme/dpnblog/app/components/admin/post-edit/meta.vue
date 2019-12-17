<template lang="html">
    <div class="uk-form-horizontal">

        <div class="uk-form-row">
            <label for="form-meta-title" class="uk-form-label">{{ 'Title' | trans }}</label>
            <div class="uk-form-controls">
                <input id="form-meta-title" class="uk-form-width-large" type="text" v-model="post.data.meta['og:title']">
            </div>
        </div>

        <div class="uk-form-row">
            <label for="form-meta-description" class="uk-form-label">{{ 'Description' | trans }}</label>
            <div class="uk-form-controls">
                <textarea id="form-meta-description" class="uk-form-width-large" rows="5" type="text" v-model="post.data.meta['og:description']"></textarea>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props:['post' , 'data' , 'form'],
    section:{
        label:'Meta',
        priority:100
    },
}
</script>
