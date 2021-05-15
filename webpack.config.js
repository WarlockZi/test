const path = require('path');
const env = require('dotenv');
console.log(env);
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');

const PATHS = {
    source: path.join(__dirname, 'public/jscss'),
    build: path.join(__dirname, 'public/build')
};

module.exports = {
    mode: 'development',
    devtool: 'source-map',
    entry: {
        admin: PATHS.source + '/Adm_crm/admin_crm_user.js',
        adminCategory: PATHS.source + '/Adm_catalog/adm_category.js',
        cabinet: PATHS.source + '/User/user_cabinet.js',
        freeTest: PATHS.source + '/Freetest/free-test.js',
        login: PATHS.source + '/User/user_login.js',
        mainIndex: PATHS.source + '/Main/main_index.js',
        test: PATHS.source + '/Test/test.js',
    },
    output: {
        chunkFilename: '[name].bundle.js',
        path: PATHS.build,
        filename: "[name].js"
    },

    optimization: {
        minimize: true,
        minimizer: [new TerserJSPlugin({})],
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                use: [
                    {
                        loader: 'babel-loader',
                    }
                ],
            },
            {
                test: /\.(?:ico|gif|png|jpg|jpeg)$/i,
                type: 'asset/resource',
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {},
                    }, 'css-loader','postcss-loader',
                    'sass-loader',
                ],
            },
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[id].css',
            ignoreOrder: false, // Enable to remove warnings about conflicting order
        }),

        new CleanWebpackPlugin(),

    ],


    devServer: {  // configuration for webpack-dev-server
        contentBase: './public/build',  //source of static assets
        port: 7700, // port to run dev-server
    }

};



