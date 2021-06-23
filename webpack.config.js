const env = require('dotenv').config().parsed

const path = require('path')
const src = path.resolve(__dirname, 'public/src')

const HtmlWebpackPlugin = require('html-webpack-plugin')
const {CleanWebpackPlugin} = require('clean-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const config = {

    output: {
        path: path.resolve(__dirname, 'public/dist'),
        filename: "[name].js",
        publicPath: '/public/dist/',
        // chunkFilename: '[name].js'
    },
    // devServer: {
    //     port: 3000,// http://[devServer.host]:[devServer.port]/[output.publicPath]/[output.filename]
    //     open: 'http://localhost:3000/public/dist/out.html',
    //     contentBase: path.resolve(src),
    //     watchContentBase: true,
    //     liveReload: true,
    //     hot:true,
    // },
    plugins: [
        new MiniCssExtractPlugin,
        // new HtmlWebpackPlugin({
        //     filename: 'out.html',
        //     template: src + '/template.html',
        // }),
        new CleanWebpackPlugin(),
    ],
    module: {
        rules: [
            // {test: /\.js$/, loader: 'babel-loader', exclude: '/node_modules/'},
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        // presets: ['@babel/preset-env'],
                        // plugins: ['@babel/plugin-transform-runtime']
                    }
                }
            },

            {test: /\.(?:ico|gif|png|jpg|jpeg)$/i, type: 'asset/resource',},
            {test: /\.(sa|sc|c)ss$/, use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader',]},
        ]
    },
};

module.exports = () => {
    let isDev = env.MODE==='dev'
    config.cache = !isDev
    config.mode = isDev ? 'development' : 'production'
    config.devtool = isDev ? 'source-map' : false
    config.target = isDev ? "web" : "browserslist"

    config.entry = {
        admin: path.resolve(src, 'Admin/admin.js'),
        adminCategory: path.resolve(src, 'Adm_catalog/adm_category.js'),
        cabinet: path.resolve(src, 'User/cabinet.js'),
        login: path.resolve(src, 'User/login.js'),
        // freeTest: path.resolve(src, 'Freetest/free-test.js'),
        test: path.resolve(src, 'Test/test.js'),
        main: path.resolve(src, 'Main/main.js'),

    }

    // config.optimization = isDev ?  {
    //     runtimeChunk: 'single',
    //     splitChunks: {
    //         cacheGroups: {
    //             vendor: {
    //                 test: /[\\/]node_modules[\\/]/,
    //                 name: 'vendors',
    //                 chunks: 'all',
    //             },
    //         },
    //     },



    // }:''
    console.log(config.devtool)
    // console.log(env)
    return config

}

