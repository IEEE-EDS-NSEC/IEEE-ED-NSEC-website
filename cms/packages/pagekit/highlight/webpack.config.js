module.exports = [
    {
        entry: {
            "highlight-settings": "./app/components/highlight-settings.vue"
        },
        output: {
            filename: "./app/bundle/[name].js"
        },
        module: {
            loaders: [
                { test: /\.vue$/, loader: "vue" }
            ]
        }
    }

];
