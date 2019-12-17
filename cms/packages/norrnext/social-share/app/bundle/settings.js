/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(1)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] app\\components\\settings.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(2)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  var id = "_v-4746994c/settings.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 1 */
/***/ function(module, exports) {

	'use strict';

	module.exports = {
	    props: ['package'],
	    settings: true,
	    methods: {
	        save: function save() {
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
	    ready: function ready() {
	        (function () {
	            var po = document.createElement('script');po.type = 'text/javascript';po.async = true;po.src = 'https://apis.google.com/js/platform.js';var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(po, s);
	        })();
	        !function (d, s, id) {
	            var js,
	                fjs = d.getElementsByTagName(s)[0],
	                p = /^http:/.test(d.location) ? 'http' : 'https';if (!d.getElementById(id)) {
	                js = d.createElement(s);js.id = id;js.src = p + '://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js, fjs);
	            }
	        }(document, 'script', 'twitter-wjs');
	    }
	};
	window.Extensions.components['settings-social-share'] = module.exports;

/***/ },
/* 2 */
/***/ function(module, exports) {

	module.exports = "\n<style>\n    ul.social-share-list li {display: inline-block;  vertical-align: bottom; padding: 3px 0}\n</style>\n<div class=\"uk-form uk-form-horizontal\">\n    <div class=\"uk-margin uk-flex uk-flex-space-between uk-flex-wrap\" data-uk-margin>\n        <div class=\"uk-width-medium-1-1 uk-container-center uk-margin-bottom\">\n            <div class=\"uk-panel\">\n                <p class=\"uk-text-danger uk-text-center\">{{ 'You are using limited version with backlink to NorrNext website.' | trans }} <a class=\"uk-button uk-button-success uk-margin-top\" href=\"//www.norrnext.com/extensions/product/pkb-social-share\" target=\"_blank\">{{ 'Get Pro Version!' | trans }}</a></p>\n            </div>\n        </div>\n        <div data-uk-margin>\n            <h2 class=\"uk-margin-remove\">{{ 'PKB Social Share Settings' | trans }}</h2>\n        </div>\n        <div data-uk-margin>\n            <button class=\"uk-button uk-button-primary\" @click=\"save\">{{ 'Save' | trans }}</button>\n        </div>\n    </div>\n    <fieldset>\n        <legend>{{ 'Layout' | trans }}</legend>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-position\" class=\"uk-form-label\">{{ 'Position' | trans }}</label>\n          <div id=\"field-buttons-position\" class=\"uk-form-controls uk-form-controls-text\">\n              <select v-model=\"package.config.buttons.position\">\n                <option value=\"static\">{{ 'Static' | trans }}</option>\n                <option value=\"fixed-left\">{{ 'Fixed Left' | trans }}</option>\n                <option value=\"fixed-right\">{{ 'Fixed Right' | trans }}</option>\n              </select>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-size\" class=\"uk-form-label\">{{ 'Button Size' | trans }}</label>\n          <div id=\"field-buttons-size\" class=\"uk-form-controls uk-form-controls-text\">\n              <select v-model=\"package.config.buttons.size\">\n                <option value=\"mini\">{{ 'Mini' | trans }}</option>\n                <option value=\"small\">{{ 'Small' | trans }}</option>\n                <option value=\"default\">{{ 'Default' | trans }}</option>\n                <option value=\"large\">{{ 'Large' | trans }}</option>\n              </select>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-counters\" class=\"uk-form-label\">{{ 'Counters' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-counters\" type=\"checkbox\" value=\"buttons.counters\" v-model=\"package.config.buttons.counters\">\n              {{ 'Show Counters in Button' | trans }}</label>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-text\" class=\"uk-form-label\">{{ 'Text' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-text\" type=\"checkbox\" value=\"buttons.text\" v-model=\"package.config.buttons.text\">\n              {{ 'Show Text in Button' | trans }}</label>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-icons\" class=\"uk-form-label\">{{ 'Icons' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-icons\" type=\"checkbox\" value=\"buttons.icons\" v-model=\"package.config.buttons.icons\">\n              {{ 'Show Icon in Button' | trans }}</label>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-responsive\" class=\"uk-form-label\">{{ 'Responsive Buttons' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-responsive\" type=\"checkbox\" value=\"buttons.icons\" v-model=\"package.config.buttons.responsive\">\n              {{ 'Responsive Size Buttons' | trans }}</label>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-responsivetext\" class=\"uk-form-label\">{{ 'Responsive Text Remove' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-responsivetext\" type=\"checkbox\" value=\"buttons.icons\" v-model=\"package.config.buttons.responsivetext\">\n              {{ 'Responsive Text Remove' | trans }}</label>\n          </div>\n        </div>\n    </fieldset>\n    <fieldset class=\"uk-margin-top\">\n        <legend>{{ 'Share Buttons' | trans }}</legend>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-fb\" class=\"uk-form-label\">{{ 'Facebook' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-fb\" type=\"checkbox\" value=\"buttons.fb\" v-model=\"package.config.buttons.fb\">\n              {{ 'Show Facebook share button' | trans }}</label>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-tw\" class=\"uk-form-label\">{{ 'Twitter' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-tw\" type=\"checkbox\" value=\"buttons.tw\" v-model=\"package.config.buttons.tw\">\n              {{ 'Show Twitter share button' | trans }}</label>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-gp\" class=\"uk-form-label\">{{ 'Google Plus' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-gp\" type=\"checkbox\" value=\"buttons.gp\" v-model=\"package.config.buttons.gp\">\n              {{ 'Show Google Plus share button' | trans }}</label>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-pt\" class=\"uk-form-label\">{{ 'Pinterest' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-pt\" type=\"checkbox\" value=\"buttons.pt\" v-model=\"package.config.buttons.pt\">\n              {{ 'Show Pinterest share button' | trans }}</label>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-vk\" class=\"uk-form-label\">{{ 'Vk' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-vk\" type=\"checkbox\" value=\"buttons.vk\" v-model=\"package.config.buttons.vk\">\n              {{ 'Show Vk share button' | trans }}</label>\n          </div>\n        </div>\n        <div class=\"uk-form-row\">\n          <label for=\"field-buttons-li\" class=\"uk-form-label\">{{ 'LinkedIn' | trans }}</label>\n          <div class=\"uk-form-controls uk-form-controls-text\">\n            <label><input id=\"field-buttons-li\" type=\"checkbox\" value=\"buttons.li\" v-model=\"package.config.buttons.li\">\n              {{ 'Show LinkedIn share button' | trans }}</label>\n          </div>\n        </div>\n    </fieldset>\n    <div class=\"uk-width-medium-1-1 uk-container-center uk-margin-top\">\n        <div class=\"uk-panel uk-panel-box uk-panel-box-primary\">\n            <p class=\"uk-text-center\">{{ 'Extensions made with love by NorrNext.' | trans }}</p>\n            <ul class=\"uk-text-center social-share-list\">\n                <li>\n                    <iframe\n                        src=\"//www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fnorrnext&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21\"\n                        scrolling=\"no\"\n                        frameborder=\"0\"\n                        style=\"border:none; overflow:hidden; height:20px; width:120px\"\n                        allowtransparency=\"true\">\n                    </iframe>\n                </li>\n                <li>\n                    <div class=\"g-follow\" data-href=\"https://plus.google.com/108999239898392136664\" data-rel=\"author\"></div>\n                </li>\n                <li>\n                    <a href=\"//twitter.com/norrnext\" class=\"twitter-follow-button\" data-show-count=\"true\">Follow @norrnext</a>\n                </li>\n            </ul>\n            <p class=\"uk-text-center\">\n                <a href=\"//www.norrnext.com/extensions/product/pkb-social-share\" target=\"_blank\">{{ 'Home Page' | trans }}</a> |\n                <a href=\"//www.norrnext.com/docs/pagekit-free-widgets/pkb-social-share\" target=\"_blank\">{{ 'Documentation' | trans }}</a> |\n                <a href=\"//www.norrnext.com/forum/pkb-social-share\" target=\"_blank\">{{ 'Support' | trans }}</a>\n            </p>\n        </div>\n    </div>\n</div>\n";

/***/ }
/******/ ]);