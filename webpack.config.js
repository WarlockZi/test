const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const path = require('path');
const webpack = require('webpack');
const TerserPlugin = require('terser-webpack-plugin');
const PATHS = {
    source: path.join(__dirname, 'public/jscss'),
    build: path.join(__dirname, 'public/build')
}

module.exports = {
    mode: 'development',
    devtool: "source-map",
    watch: true, //live-reloading
    entry: {
        cabinet: PATHS.source + '/User/user_cabinet.js',
        login: PATHS.source + '/User/user_login.js',
        admin: PATHS.source + '/Adm_crm/admin_crm_user.js',
        mainIndex: PATHS.source + '/Main/main_index.js',
        adminCategory: PATHS.source + '/Adm_catalog/category.js',
    },
    output: {
        chunkFilename: '[name].bundle.js',
        path: PATHS.build,
        filename: "[name].js"
    },
    module: {},

    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            parallel: true,
            parallel: 4,
            cache: true,
        })],
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            "window.jQuery": "jquery"
        }),
        new webpack.ProvidePlugin({
            slick:'slick-carousel'
        }),
        new CleanWebpackPlugin(),
    ]

}