<template>

    <div class="uk-form uk-form-horizontal">

        <h1>{{ 'Highlight Settings' | trans }}</h1>

        <div class="uk-form-row">
            <label class="uk-form-label" for="input-style">{{ 'Style' | trans }}</label>
            <div class="uk-form-controls">
                <select id="input-style" v-model="package.config.style" v-show="styles.length">
                    <option v-for="option in styles" :value="option">
                        {{ option }}
                    </option>
                </select>
                <div v-else>
                    {{ 'Loading styles...' | trans }}
                </div>
            </div>
        </div>

        <div class="uk-form-row">
            <label class="uk-form-label">{{ 'Pages' | trans }}</label>
            <div class="uk-form-controls uk-form-controls-text">
                <input-tree :active.sync="package.config.nodes"></input-tree>
            </div>
        </div>

        <div class="uk-form-row">
            <label class="uk-form-label" for="input-enable-auto">{{ 'Auto Detect' | trans }}</label>
            <div class="uk-form-controls uk-form-controls-text">
                <input type="checkbox" id="input-enable-auto" name="input-enable-auto" value="auto" v-model="package.config.autodetect">
                <label for="input-enable-auto">
                    {{ 'Only load when code found on page' | trans }}
                </label>
            </div>
        </div>

        <div class="uk-form-row uk-margin-top">
            <div class="uk-form-controls">
                <button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>
            </div>
        </div>

    </div>

</template>

<script>

    module.exports = {

        settings: true,

        props: ['package'],

        data: function() {
            return {
                styles: []
            };
        },

        created: function () {
            this.load();
        },

        methods: {

            load: function () {
                this.$http.get('admin/highlight/config').then(function (response) {
                    this.$set('styles', response.data.styles);
                }).catch(function () {
                    this.$notify('Could not load styles.');
                });
            },

            save: function () {
               this.$http.post('admin/system/settings/config', {
                   name: 'highlight',
                   config: this.package.config
               }).then(function () {
                   this.$notify('Settings saved.', '');
               }).catch(function (response) {
                   this.$notify(response.message, 'danger');
               }).finally(function () {
                   this.$parent.close();
               });
           }
       }
    };

    window.Extensions.components['highlight-settings'] = module.exports;
</script>
