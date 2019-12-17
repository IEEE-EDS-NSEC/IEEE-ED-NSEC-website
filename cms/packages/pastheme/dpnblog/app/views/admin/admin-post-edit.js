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
        settings: require('../../components/admin/post-edit/settings.vue'),
        meta: require('../../components/admin/post-edit/meta.vue'),
    }
}

Vue.ready(window.Post);
