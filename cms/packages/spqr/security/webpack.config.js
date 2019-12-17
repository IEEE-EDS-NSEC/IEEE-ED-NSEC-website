module.exports = [
	{
		entry: {
			"settings": "./app/views/admin/settings.js",
			"ban-index": "./app/views/admin/ban-index",
			"ban-edit": "./app/views/admin/ban-edit"
		},
		output: {
			filename: "./app/bundle/[name].js"
		},
		module: {
			loaders: [
				{test: /\.vue$/, loader: "vue"},
				{test: /\.js$/, exclude: /node_modules/, loader: "babel-loader"}
			]
		}
	}

];