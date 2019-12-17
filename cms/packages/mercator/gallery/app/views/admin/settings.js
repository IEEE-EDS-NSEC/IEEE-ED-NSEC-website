window.settings = {

	el: '#settings',

	data: {
		config: $data.config
	},

	methods: {

		save: function () {
			this.$http.post('admin/gallery/save', {config: this.config}, function () {
				this.$notify('Settings saved.');
			}).error(function (data) {
				this.$notify(data, 'danger');
			});
		}
	},
	components: {}
};

Vue.ready(window.settings);
