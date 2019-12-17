module.exports = {
    el: '#settings',
    name:'settings',
    data:{
        config: window.$data.config
    },

    methods:{
        save:function(){
            this.$http.post('admin/system/settings/config', { name: 'dpnblog', config: this.config }).then(function () {
                    this.$notify('Settings saved.');
                }, function (res) {
                    this.$notify(res.data, 'danger');
                }
            );
        }
    }
}

Vue.ready(module.exports)
