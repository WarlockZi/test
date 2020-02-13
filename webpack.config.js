const path = require('path');
const WebpackDevServer = require('webpack-dev-server');
const webpack = require('webpack');
const TerserPlugin = require('terser-webpack-plugin');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const PATHS = {
    source: path.join(__dirname, 'public/jscss'),
    build: path.join(__dirname, 'public/build')
};

module.exports = {
    mode: 'development',
    devtool: "source-map",
    watch: true, //live-reloading
    entry: {
        cabinet: PATHS.source + '/User/user_cabinet.js',
        login: PATHS.source + '/User/user_login.js',
        admin: PATHS.source + '/Adm_crm/admin_crm_user.js',
        mainIndex: PATHS.source + '/Main/main_index.js',
        adminCategory: PATHS.source + '/Adm_catalog/adm_category.js',
    },
    output: {
        chunkFilename: '[name].bundle.js',
        path: PATHS.build,
        filename: "[name].js"
    },
    resolve: {
        modules: ['node_modules']
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin({
            parallel: true,
            cache: true,
        })],
    },

    module: {
        rules: [
            {
                test: /\.js/,
                loader: 'babel-loader',
                exclude: /(node_modules)/
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    // Creates `style` nodes from JS strings
                    // 'style-loader',
                    // Translates CSS into CommonJS
                    'css-loader',
                    // Compiles Sass to CSS
                    'sass-loader',
                    // 'css-loader'
                ],
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[id].css',
        }),
        // new webpack.ProvidePlugin({
        //     $: 'jquery',
        //     jQuery: 'jquery',
        //     "window.jQuery": "jquery"
        // }),
        // new webpack.ProvidePlugin({
        //     slick: 'slick-carousel'
        // }),
        new CleanWebpackPlugin(),
    ]


}



