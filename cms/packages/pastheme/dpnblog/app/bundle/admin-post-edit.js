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

	window.Post = {
	    name: 'PostEdit',
	    el:'#post',
	    data:function(){
	        return _.merge({
	            sections: [],
	        } , window.$data);
	    },

	    created: function () {
	        var sections = [];
	        _.forIn(this.$options.components, function (component, name) {
	            var options = component.options || {};
	            if (options.section) {
	                sections.push(_.extend({name: name, priority: 0}, options.section));
	            }
	        });
	        this.$set('sections', _.sortBy(sections, 'priority'));
	    },

	    ready:function(){
	        this.resource = this.$resource('admin/apidpnblog/post{/id}');
	        this.tab = UIkit.tab(this.$els.tab, {connect: this.$els.content});
	    },

	    methods:{
	        save:function(){
	            this.$http.post('admin/apidpnblog/post/save' , {post:this.data.post}).then(res => {
	                if (res.data.status == 200) {
	                    if (!this.data.post.id) {
	                        window.history.replaceState({}, '', this.$url.route('admin/dpnblog/posts/edit', {id: res.data.data.id}))
	                    }
	                    this.$set('data.post', res.data.data);
	                    this.$notify(res.data.msg);
	                }else{
	                    this.$notify(res.data.status+': '+res.data.msg , 'danger');
	                }
	            } , err => {
	                this.$notify(res.data.status+': '+res.data.msg , 'danger');
	            })
	        }
	    },

	    components: {
	        settings: __webpack_require__(1),
	        meta: __webpack_require__(16),
	    }
	}

	Vue.ready(window.Post);


/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	var __vue_styles__ = {}
	__vue_script__ = __webpack_require__(2)
	if (Object.keys(__vue_script__).some(function (key) { return key !== "default" && key !== "__esModule" })) {
	  console.warn("[vue-loader] app/components/admin/post-edit/settings.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(15)
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
	  var id = "_v-3b0b969a/settings.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 2 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {

	    props: ['post', 'data', 'form'],

	    section: {
	        label: 'Post',
	        priority: 0
	    },

	    data: function data() {
	        return {
	            categories: '',
	            tags: []
	        };
	    },

	    ready: function ready() {
	        this.getCategories();
	        this.getTags();
	    },

	    methods: {

	        goodies: function goodies() {
	            $('#goodies-tag').tagEditor({
	                initialTags: this.post.tags,
	                autocomplete: {
	                    delay: 0,
	                    source: this.tags
	                },
	                forceLowercase: true,
	                placeholder: 'Enter tags ...'
	            });
	        },

	        getTags: function getTags() {
	            var _this = this;

	            this.$http.get('admin/apidpnblog/tags/getalltags').then(function (res) {
	                _this.tags = res.data.data;
	            });
	        },

	        getCategories: function getCategories() {
	            var _this2 = this;

	            this.$http.get('admin/apidpnblog/post/get-categories').then(function (res) {
	                if (res.data.status == 200) {
	                    _this2.categories = res.data.data;
	                    UIkit.notify(res.data.msg, 'primary');
	                } else {
	                    UIkit.notify(res.data.msg);
	                }
	            });
	        }
	    },

	    components: {
	        blogImage: __webpack_require__(3),
	        blogVideo: __webpack_require__(6),
	        blogGallery: __webpack_require__(9),
	        inputTags: __webpack_require__(12)
	    }

	};

/***/ },
/* 3 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	var __vue_styles__ = {}
	__vue_script__ = __webpack_require__(4)
	if (Object.keys(__vue_script__).some(function (key) { return key !== "default" && key !== "__esModule" })) {
	  console.warn("[vue-loader] app/components/admin/post-edit/post-style/image.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(5)
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
	  var id = "_v-4437eac7/image.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 4 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {
	    props: ['post']
	};

/***/ },
/* 5 */
/***/ function(module, exports) {

	module.exports = "\n<input-image-meta :image.sync=\"post.data.image\" class=\"pk-image-max-height\"></input-image-meta>\n";

/***/ },
/* 6 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	var __vue_styles__ = {}
	__vue_script__ = __webpack_require__(7)
	if (Object.keys(__vue_script__).some(function (key) { return key !== "default" && key !== "__esModule" })) {
	  console.warn("[vue-loader] app/components/admin/post-edit/post-style/video.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(8)
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
	  var id = "_v-6ffa7432/video.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 7 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {
	    props: ['post'],

	    data: function data() {
	        return _.merge({ source: '' }, $pagekit);
	    },

	    computed: {
	        selectButton: function selectButton() {
	            var selected = this.$refs.finder.getSelected();
	            return selected.length === 1 && this.$refs.finder.isVideo(selected[0]);
	        }
	    },

	    methods: {
	        pick: function pick() {
	            this.$refs.modal.open();
	        },

	        video: function video() {
	            this.$refs.video.open();
	        },

	        select: function select() {
	            this.post.data.video.source = this.$refs.finder.getSelected()[0];
	            this.$refs.video.close();
	        },

	        remove: function remove() {
	            this.post.data.video.source = '';
	        }

	    }
	};

/***/ },
/* 8 */
/***/ function(module, exports) {

	module.exports = "\n <a class=\"uk-placeholder uk-text-center uk-display-block uk-margin-remove\" v-if=\"!post.data.video.source\" @click.prevent=\"pick\">\n     <img width=\"60\" height=\"60\" :alt=\"'Placeholder Video' | trans\" :src=\"$url('app/system/assets/images/placeholder-video.svg')\">\n     <p class=\"uk-text-muted uk-margin-small-top\">{{ 'Add Video'| trans }}</p>\n </a>\n\n <div class=\"uk-overlay uk-overlay-hover uk-visible-hover\" v-if=\"post.data.video.source\">\n\n     <img :src=\"$url(post.data.video.image)\" v-if=\"post.data.video.image\">\n\n     <video controls class=\"uk-responsive-width uk-width-1-1\" v-if=\"!post.data.video.image\">\n         <source :src=\"$url(post.data.video.source)\" type=\"video/mp4\">\n     </video>\n     <div class=\"uk-overlay-panel uk-overlay-background uk-overlay-fade\"></div>\n\n     <a class=\"uk-position-cover\" @click.prevent=\"pick\"></a>\n\n     <div class=\"uk-panel-badge pk-panel-badge uk-hidden\">\n         <ul class=\"uk-subnav pk-subnav-icon\">\n             <li><a class=\"pk-icon-delete pk-icon-hover\" :title=\"'Delete' | trans\" data-uk-tooltip=\"{delay: 500}\" @click.prevent=\"remove\"></a></li>\n         </ul>\n     </div>\n </div>\n\n <v-modal v-ref:modal>\n     <form class=\"uk-form uk-form-stacked\" @submit=\"update\">\n\n         <div class=\"uk-modal-header\">\n             <h2 class=\"uk-text-capitalize\">{{ 'Video' | trans }}</h2>\n         </div>\n\n         <div class=\"uk-form-row\">\n             <input-image :source.sync=\"post.data.video.image\" class=\"pk-image-max-height\"></input-image>\n         </div>\n\n         <div class=\"uk-form-row\">\n             <a class=\"uk-placeholder uk-text-center uk-display-block uk-margin-remove\" v-if=\"!post.data.video.source\" @click.prevent=\"video\">\n                 <img width=\"60\" height=\"60\" :alt=\"'Placeholder Video' | trans\" :src=\"$url('app/system/assets/images/placeholder-video.svg')\">\n                 <p class=\"uk-text-muted uk-margin-small-top\">{{ 'Add Video'| trans }}</p>\n             </a>\n         </div>\n\n         <div class=\"uk-overlay uk-overlay-hover uk-visible-hover\" v-if=\"post.data.video.source\">\n             <video controls class=\"uk-responsive-width uk-width-1-1\">\n                 <source :src=\"$url(post.data.video.source)\" type=\"video/mp4\">\n             </video>\n             <div class=\"uk-overlay-panel uk-overlay-background uk-overlay-fade\"></div>\n\n             <a class=\"uk-position-cover\" @click.prevent=\"pick\"></a>\n\n             <div class=\"uk-panel-badge pk-panel-badge uk-hidden\">\n                 <ul class=\"uk-subnav pk-subnav-icon\">\n                     <li><a class=\"pk-icon-delete pk-icon-hover\" :title=\"'Delete' | trans\" data-uk-tooltip=\"{delay: 500}\" @click.prevent=\"remove\"></a></li>\n                 </ul>\n             </div>\n         </div>\n\n         <v-modal v-ref:video large>\n             <panel-finder :root=\"storage\" :modal=\"true\" v-ref:finder></panel-finder>\n             <div class=\"uk-modal-footer uk-text-right\">\n                 <button class=\"uk-button uk-button-link uk-modal-close\" type=\"button\">{{ 'Cancel' | trans }}</button>\n                 <button class=\"uk-button uk-button-primary\" type=\"button\" :disabled=\"!selectButton\" @click.prevent=\"select\">{{ 'Select' | trans }}</button>\n             </div>\n         </v-modal>\n\n         <div class=\"uk-modal-footer uk-text-right\">\n             <button class=\"uk-button uk-button-link uk-modal-close\" type=\"button\">{{ 'Complete' | trans }}</button>\n        </div>\n\n     </form>\n</v-modal>\n\n";

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	var __vue_styles__ = {}
	__vue_script__ = __webpack_require__(10)
	if (Object.keys(__vue_script__).some(function (key) { return key !== "default" && key !== "__esModule" })) {
	  console.warn("[vue-loader] app/components/admin/post-edit/post-style/gallery.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(11)
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
	  var id = "_v-5318203e/gallery.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 10 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {
	    props: ['post'],

	    methods: {
	        pick: function pick() {
	            this.$refs.modal.open();
	        },

	        field: function field() {
	            this.post.data.gallery.push({
	                image: ''
	            });
	        },

	        remove: function remove(indis) {
	            this.post.data.gallery.splice(indis, 1);
	        }
	    }
	};

/***/ },
/* 11 */
/***/ function(module, exports) {

	module.exports = "\n<a class=\"uk-placeholder uk-text-center uk-display-block uk-margin-remove\" @click.prevent=\"pick\">\n    <img width=\"105\" height=\"105\" :alt=\"'Placeholder Video' | trans\" :src=\"$url('packages/pastheme/dpnblog/assets/image/gallery.svg')\">\n    <p class=\"uk-text-muted uk-margin-small-top\">{{ 'Add Gallery'| trans }}</p>\n</a>\n\n<v-modal v-ref:modal large>\n    <div class=\"uk-clearfix\">\n        <button class=\"uk-button uk-button-primary uk-align-right\" @click.prevent=\"field\">{{ 'New Field' | trans }}</button>\n    </div>\n\n    <div class=\"uk-margin\">\n        <div class=\"uk-margin-small\" v-for=\"(indis , fieldGallery) in post.data.gallery\">\n            <input-image :source.sync=\"fieldGallery.image\" class=\"pk-image-max-height uk-width-1-1\"></input-image>\n            <button class=\"uk-button uk-button-text\" @click.prevent=\"remove(indis)\">{{ 'Remove Field'  | trans }}</button>\n        </div>\n    </div>\n</v-modal>\n\n";

/***/ },
/* 12 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	var __vue_styles__ = {}
	__vue_script__ = __webpack_require__(13)
	if (Object.keys(__vue_script__).some(function (key) { return key !== "default" && key !== "__esModule" })) {
	  console.warn("[vue-loader] app/module/input-tags.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(14)
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
	  var id = "_v-d479f6b6/input-tags.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 13 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {
	    props: ['post', 'tags'],

	    data: {
	        input: ''
	    },

	    methods: {
	        remove: function remove(indis) {
	            this.post.splice(indis, 1);
	        },

	        add: function add(e) {
	            e.preventDefault();
	            if (this.input) {
	                this.post.push(this.input);
	                this.input = '';
	            }
	        }
	    }

	};

/***/ },
/* 14 */
/***/ function(module, exports) {

	module.exports = "\n\n<div class=\"tm-tags\"data-uk-margin>\n\t<ul>\n\t\t<li v-for=\"(indis , tag) in post\"><a @click=\"remove(indis)\">{{tag}}</a></li>\n\t</ul>\n</div>\n\n<div data-uk-margin>\n    <div class=\"uk-form-row\">\n        <input type=\"text\" list=\"tagList\" class=\"uk-width-1-1\" :placeholder=\"'Enter Tags' | trans\" v-model=\"input\" @keydown.enter.prevent=\"add\">\n        <datalist id=\"tagList\">\n            <option v-for=\"tag in tags\" v-bind:value=\"tag\">\n        </datalist>\n    </div>\n</div>\n\n";

/***/ },
/* 15 */
/***/ function(module, exports) {

	module.exports = "\n\n<div class=\"uk-grid pk-grid-large\" data-uk-grid-margin>\n\n    <div class=\"uk-form pk-width-content uk-grid-margin\">\n\n        <div class=\"uk-form-row\">\n            <div class=\"uk-form-controls\">\n                <input type=\"text\" class=\"uk-form-large uk-width-1-1\" :placeholder=\"'Title' | trans\" v-model=\"post.title\" required>\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <label class=\"uk-form-label\">{{'Excerpt' | trans}}</label>\n            <div class=\"uk-form-controls\">\n                <v-editor id=\"post-content\" :value.sync=\"post.excerpt\" :options=\"{markdown : post.data.markdown , height:100}\"></v-editor>\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <label class=\"uk-form-label\">{{'Content' | trans}}</label>\n            <div class=\"uk-form-controls\">\n                <v-editor id=\"post-content\" :value.sync=\"post.content\" :options=\"{markdown : post.data.markdown}\"></v-editor>\n            </div>\n        </div>\n\n    </div>\n\n    <div class=\"pk-width-sidebar\">\n\n        <div class=\"uk-panel uk-panel-box uk-panel-box-muted\">\n            <div class=\"uk-panel-title\">\n                <h3>{{'Post Style' | trans}}</h3>\n            </div>\n            <div class=\"uk-form-row\">\n                <div class=\"uk-form-controls\">\n                    <p class=\"uk-margin-small\">\n                        <label><input type=\"radio\" v-model=\"post.post_style\" value=\"0\"> <i class=\"uk-icon-file\"></i> {{'Default' | trans}}</label>\n                    </p>\n                    <p class=\"uk-margin-small\">\n                        <label><input type=\"radio\" v-model=\"post.post_style\" value=\"1\"> <i class=\"uk-icon-youtube-play\"></i> {{'Video' | trans}}</label>\n                    </p>\n                    <p class=\"uk-margin-small\">\n                        <label><input type=\"radio\" v-model=\"post.post_style\" value=\"2\"> <i class=\"uk-icon-list-alt\"></i> {{'Article' | trans}}</label>\n                    </p>\n                    <p class=\"uk-margin-small\">\n                        <label><input type=\"radio\" v-model=\"post.post_style\" value=\"3\"> <i class=\"uk-icon-image\"></i> {{'Gallery' | trans}}</label>\n                    </p>\n                    <p class=\"uk-margin-small\">\n                        <label><input type=\"radio\" v-model=\"post.post_style\" value=\"4\"> <i class=\"uk-icon-mortar-board\"></i> {{'Document' | trans}}</label>\n                    </p>\n                </div>\n            </div>\n        </div>\n\n        <div class=\"uk-margin\">\n            <blog-image :post.sync=\"post\" v-if=\"\n            post.post_style == 0 ||\n            post.post_style == 2 ||\n            post.post_style == 4\n            \"></blog-image>\n        </div>\n\n        <div class=\"uk-margin\">\n            <blog-video :post.sync=\"post\" v-if=\"post.post_style == 1\"></blog-video>\n        </div>\n\n        <div class=\"uk-margin\">\n            <blog-gallery :post.sync=\"post\" v-if=\"post.post_style == 3\"></blog-gallery>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <label for=\"form-slug\" class=\"uk-form-label\">{{ 'Slug' | trans }}</label>\n            <div class=\"uk-form-controls\">\n                <input id=\"form-slug\" class=\"uk-width-1-1\" type=\"text\" v-model=\"post.slug\">\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <label class=\"uk-form-label\">{{ 'Categories' | trans}}</label>\n            <div class=\"uk-form-controls\">\n                <select class=\"uk-width-1-1\" v-model=\"post.category_id\">\n                    <option v-for=\"category in categories\" v-bind:value=\"category.id\">\n                        {{category.title}}\n                    </option>\n                </select>\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <div>\n                <input-tags :post.sync=\"post.tags\" :tags.sync=\"tags\"></input-tags>\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <label for=\"form-status\" class=\"uk-form-label\">{{ 'Status' | trans }}</label>\n            <div class=\"uk-form-controls\">\n                <select id=\"form-status\" class=\"uk-width-1-1\" v-model=\"post.status\">\n                    <option v-for=\"(id, status) in data.statuses\" :value=\"id\">{{status}}</option>\n                </select>\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <label for=\"form-author\" class=\"uk-form-label\">{{ 'Author' | trans }}</label>\n            <div class=\"uk-form-controls\">\n                <select id=\"form-author\" class=\"uk-width-1-1\" v-model=\"post.user_id\">\n                    <option v-for=\"author in data.authors\" :value=\"author.id\">{{author.username}}</option>\n                </select>\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <span class=\"uk-form-label\">{{ 'Publish on' | trans }}</span>\n            <div class=\"uk-form-controls\">\n                <input-date :datetime.sync=\"post.date\"></input-date>\n            </div>\n        </div>\n\n        <div class=\"uk-form-row\">\n            <span class=\"uk-form-label\">{{ 'Restrict Access' | trans }}</span>\n            <div class=\"uk-form-controls uk-form-controls-text\">\n                <p v-for=\"role in data.roles\" class=\"uk-form-controls-condensed\">\n                    <label><input type=\"checkbox\" :value=\"role.id\" v-model=\"post.roles\" number> {{ role.name }}</label>\n                </p>\n            </div>\n        </div>\n        <div class=\"uk-form-row\">\n            <span class=\"uk-form-label\">{{ 'Options' | trans }}</span>\n            <div class=\"uk-form-controls\">\n                <label><input type=\"checkbox\" v-model=\"post.data.markdown\" value=\"1\"> {{ 'Enable Markdown' | trans }}</label>\n            </div>\n            <div class=\"uk-form-controls\">\n                <label><input type=\"checkbox\" v-model=\"post.comment_status\" value=\"1\"> {{ 'Enable Comments' | trans }}</label>\n            </div>\n        </div>\n\n    </div>\n\n</div>\n\n";

/***/ },
/* 16 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	var __vue_styles__ = {}
	__vue_script__ = __webpack_require__(17)
	if (Object.keys(__vue_script__).some(function (key) { return key !== "default" && key !== "__esModule" })) {
	  console.warn("[vue-loader] app/components/admin/post-edit/meta.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(18)
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
	  var id = "_v-150db6fc/meta.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 17 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {
	    props: ['post', 'data', 'form'],
	    section: {
	        label: 'Meta',
	        priority: 100
	    }
	};

/***/ },
/* 18 */
/***/ function(module, exports) {

	module.exports = "\n<div class=\"uk-form-horizontal\">\n\n    <div class=\"uk-form-row\">\n        <label for=\"form-meta-title\" class=\"uk-form-label\">{{ 'Title' | trans }}</label>\n        <div class=\"uk-form-controls\">\n            <input id=\"form-meta-title\" class=\"uk-form-width-large\" type=\"text\" v-model=\"post.data.meta['og:title']\">\n        </div>\n    </div>\n\n    <div class=\"uk-form-row\">\n        <label for=\"form-meta-description\" class=\"uk-form-label\">{{ 'Description' | trans }}</label>\n        <div class=\"uk-form-controls\">\n            <textarea id=\"form-meta-description\" class=\"uk-form-width-large\" rows=\"5\" type=\"text\" v-model=\"post.data.meta['og:description']\"></textarea>\n        </div>\n    </div>\n\n</div>\n";

/***/ }
/******/ ]);