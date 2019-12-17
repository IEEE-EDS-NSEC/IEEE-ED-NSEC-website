module.exports = [
    {
        entry: {
            "app/bundle/analytics": "./app/analytics"
        },
        output: {
            filename: "./[name].js"
        },
        externals: {
            "lodash": "_",
            "jquery": "jQuery",
            "vue": "Vue",
            "uikit": "UIkit",
            "dashboard": "Dashboard"
        },
        module: {
            loaders: [
                {test: /\.json$/, loader: "json"},
                {test: /\.vue$/, loader: "vue"}
            ]
        }
    }
];