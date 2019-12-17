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
/******/ ({

/***/ 0:
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	var __vue_styles__ = {}
	__vue_script__ = __webpack_require__(21)
	if (Object.keys(__vue_script__).some(function (key) { return key !== "default" && key !== "__esModule" })) {
	  console.warn("[vue-loader] app/components/link-blog.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(22)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	var __vue_options__ = typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports
	if (__vue_template__) {
	__vue_options__.template = __vue_template__
	}
	if (!__vue_options__.computed) __vue_options__.computed = {}
	Object.keys(__vue_styles__).forEach(function (key) {
	var module = __vue_styles__[key]
	__vue_options__.computed[key] = function () { return module }
	})
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  var id = "_v-5c02e434/link-blog.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },

/***/ 21:
/***/ function(module, exports) {

	'use strict';

	module.exports = {
	    props: ['link'],
	    link: {
	        label: 'Advanced Blog'
	    },

	    data: function data() {
	        return {
	            posts: [],
	            categories: []
	        };
	    },

	    ready: function ready() {
	        this.link = '@dpnblog';
	        this.getCategories();
	    },

	    filters: {
	        link: function link(category) {
	            return '@dpnblog/category/id?id=' + category.id;
	        }
	    },

	    methods: {
	        getCategories: function getCategories() {
	            var _this = this;

	            this.$http.get('admin/apidpnblog/post/get-categories').then(function (res) {
	                if (res.data.status == 200) {
	                    _this.categories = res.data.data;
	                }
	            });
	        }
	    }

	};
	window.Links.components['link-blog'] = module.exports;

/***/ },

/***/ 22:
/***/ function(module, exports) {

	module.exports = "\n<div class=\"uk-margin\" data-uk-margin>\n\n    <div class=\"uk-form-row\">\n        <select class=\"uk-width-1-1\" v-model=\"link\">\n            <option value=\"post\">{{ 'Posts View' | trans }}</option>\n            <optgroup :label=\"'Categories' | trans\">\n                <option v-for=\"category in categories\" :value=\"category | link\">{{ category.title }}</option>\n            </optgroup>\n        </select>\n    </div>\n\n</div>\n";

/***/ }

/******/ });