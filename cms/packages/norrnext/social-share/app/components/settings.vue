<template>
    <style>
        ul.social-share-list li {display: inline-block;  vertical-align: bottom; padding: 3px 0}
    </style>
    <div class="uk-form uk-form-horizontal">
        <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
            <div class="uk-width-medium-1-1 uk-container-center uk-margin-bottom">
                <div class="uk-panel">
                    <p class="uk-text-danger uk-text-center">{{ 'You are using limited version with backlink to NorrNext website.' | trans }} <a class="uk-button uk-button-success uk-margin-top" href="//www.norrnext.com/extensions/product/pkb-social-share" target="_blank">{{ 'Get Pro Version!' | trans }}</a></p>
                </div>
            </div>
            <div data-uk-margin>
                <h2 class="uk-margin-remove">{{ 'PKB Social Share Settings' | trans }}</h2>
            </div>
            <div data-uk-margin>
                <button class="uk-button uk-button-primary" @click="save">{{ 'Save' | trans }}</button>
            </div>
        </div>
        <fieldset>
            <legend>{{ 'Layout' | trans }}</legend>
            <div class="uk-form-row">
              <label for="field-buttons-position" class="uk-form-label">{{ 'Position' | trans }}</label>
              <div id="field-buttons-position" class="uk-form-controls uk-form-controls-text">
                  <select v-model="package.config.buttons.position">
                    <option value="static">{{ 'Static' | trans }}</option>
                    <option value="fixed-left">{{ 'Fixed Left' | trans }}</option>
                    <option value="fixed-right">{{ 'Fixed Right' | trans }}</option>
                  </select>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-size" class="uk-form-label">{{ 'Button Size' | trans }}</label>
              <div id="field-buttons-size" class="uk-form-controls uk-form-controls-text">
                  <select v-model="package.config.buttons.size">
                    <option value="mini">{{ 'Mini' | trans }}</option>
                    <option value="small">{{ 'Small' | trans }}</option>
                    <option value="default">{{ 'Default' | trans }}</option>
                    <option value="large">{{ 'Large' | trans }}</option>
                  </select>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-counters" class="uk-form-label">{{ 'Counters' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-counters" type="checkbox" value="buttons.counters" v-model="package.config.buttons.counters">
                  {{ 'Show Counters in Button' | trans }}</label>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-text" class="uk-form-label">{{ 'Text' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-text" type="checkbox" value="buttons.text" v-model="package.config.buttons.text">
                  {{ 'Show Text in Button' | trans }}</label>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-icons" class="uk-form-label">{{ 'Icons' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-icons" type="checkbox" value="buttons.icons" v-model="package.config.buttons.icons">
                  {{ 'Show Icon in Button' | trans }}</label>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-responsive" class="uk-form-label">{{ 'Responsive Buttons' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-responsive" type="checkbox" value="buttons.icons" v-model="package.config.buttons.responsive">
                  {{ 'Responsive Size Buttons' | trans }}</label>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-responsivetext" class="uk-form-label">{{ 'Responsive Text Remove' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-responsivetext" type="checkbox" value="buttons.icons" v-model="package.config.buttons.responsivetext">
                  {{ 'Responsive Text Remove' | trans }}</label>
              </div>
            </div>
        </fieldset>
        <fieldset class="uk-margin-top">
            <legend>{{ 'Share Buttons' | trans }}</legend>
            <div class="uk-form-row">
              <label for="field-buttons-fb" class="uk-form-label">{{ 'Facebook' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-fb" type="checkbox" value="buttons.fb" v-model="package.config.buttons.fb">
                  {{ 'Show Facebook share button' | trans }}</label>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-tw" class="uk-form-label">{{ 'Twitter' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-tw" type="checkbox" value="buttons.tw" v-model="package.config.buttons.tw">
                  {{ 'Show Twitter share button' | trans }}</label>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-gp" class="uk-form-label">{{ 'Google Plus' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-gp" type="checkbox" value="buttons.gp" v-model="package.config.buttons.gp">
                  {{ 'Show Google Plus share button' | trans }}</label>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-pt" class="uk-form-label">{{ 'Pinterest' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-pt" type="checkbox" value="buttons.pt" v-model="package.config.buttons.pt">
                  {{ 'Show Pinterest share button' | trans }}</label>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-vk" class="uk-form-label">{{ 'Vk' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-vk" type="checkbox" value="buttons.vk" v-model="package.config.buttons.vk">
                  {{ 'Show Vk share button' | trans }}</label>
              </div>
            </div>
            <div class="uk-form-row">
              <label for="field-buttons-li" class="uk-form-label">{{ 'LinkedIn' | trans }}</label>
              <div class="uk-form-controls uk-form-controls-text">
                <label><input id="field-buttons-li" type="checkbox" value="buttons.li" v-model="package.config.buttons.li">
                  {{ 'Show LinkedIn share button' | trans }}</label>
              </div>
            </div>
        </fieldset>
        <div class="uk-width-medium-1-1 uk-container-center uk-margin-top">
            <div class="uk-panel uk-panel-box uk-panel-box-primary">
                <p class="uk-text-center">{{ 'Extensions made with love by NorrNext.' | trans }}</p>
                <ul class="uk-text-center social-share-list">
                    <li>
                        <iframe
                            src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fnorrnext&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21"
                            scrolling="no"
                            frameborder="0"
                            style="border:none; overflow:hidden; height:20px; width:120px"
                            allowtransparency="true">
                        </iframe>
                    </li>
                    <li>
                        <div class="g-follow" data-href="https://plus.google.com/108999239898392136664" data-rel="author"></div>
                    </li>
                    <li>
                        <a href="//twitter.com/norrnext" class="twitter-follow-button" data-show-count="true">Follow @norrnext</a>
                    </li>
                </ul>
                <p class="uk-text-center">
                    <a href="//www.norrnext.com/extensions/product/pkb-social-share" target="_blank">{{ 'Home Page' | trans }}</a> |
                    <a href="//www.norrnext.com/docs/pagekit-free-widgets/pkb-social-share" target="_blank">{{ 'Documentation' | trans }}</a> |
                    <a href="//www.norrnext.com/forum/pkb-social-share" target="_blank">{{ 'Support' | trans }}</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: ['package'],
        settings: true,
        methods: {
            save: function () {
                this.$http.post('admin/system/settings/config', {
                    name: 'norrnext/social-share',
                    config: this.package.config
                }, function () {
                    this.$notify('Settings saved.', '');
                }).error(function (data) {
                    this.$notify(data, 'danger');
                }).always(function () {
                    this.$parent.close();
                });
            }
        },
    ready: function() {
		(function() { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/platform.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
    },		
    };
    window.Extensions.components['settings-social-share'] = module.exports;
</script>