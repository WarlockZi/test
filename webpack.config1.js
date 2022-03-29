const env = require('dotenv').config().parsed
const webpack = require('webpack')
const path = require('path')
const src = path.resolve(__dirname, 'public/src')

const HtmlWebpackPlugin = require('html-webpack-plugin')
const {CleanWebpackPlugin} = require('clean-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const config = {

  watch: true,
  output: {
    path: path.join(__dirname, './public/dist/'),
    filename: "[name].js",
    publicPath: './public/dist/',
    // chunkFilename: '[name].js'
  },
  devServer: {
    port: 3000,// http://[devServer.host]:[devServer.port]/[output.publicPath]/[output.filename]
    open: true,

    client: {
      progress: true,
      overlay: true,
    },
    // static:  {
    //   directory : path.join(__dirname, '/'),
    //   publicPath: '/',
    // },
    watchFiles: {
      paths: ['src/**/*', 'public/**/*'],
    },
    compress: true,
    liveReload: true,
  },
  plugins: [
    new MiniCssExtractPlugin,
    // new HtmlWebpackPlugin({
    //     filename: 'out.html',
    //     template: src + '/template.html',
    // }),
    // new CleanWebpackPlugin(),
    new webpack.HotModuleReplacementPlugin(),
  ],
  // optimization: {
  //     runtimeChunk: 'single',
  // },

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


      {
        test: /\.(?:ico|gif|png|jpg|jpeg|svg|woff|woff2|eot|ttf|otf)$/i,
        type: 'asset/resource',
      },
      // {test: /\.svg/, type: 'asset/inline'},
      {test: /\.(sa|sc|c)ss$/, use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader',]},
    ]
  },
};

module.exports = () => {

  let isDev = env.MODE === 'dev'
  config.cache = !isDev
  config.mode = isDev ? 'development' : 'production'
  // config.mode = 'production'
  // config.devtool = false
  config.devtool = isDev ? 'source-map' : false
  config.target = isDev ? "web" : "browserslist"

  config.entry = {
    admin: path.resolve(src, 'Admin/admin.js'),
    // adminCategory: path.resolve(src, 'Adm_catalog/adm_category.js'),
    auth: path.resolve(src, 'Auth/auth.js'),
    // freeTest: path.resolve(src, 'Freetest/free-test.js'),
    test: path.resolve(src, 'Test/test.js'),
    test_edit: path.resolve(src, 'Test/test-edit.js'),
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
  console.log(config.mode)
  // console.log(env)
  return config
}

