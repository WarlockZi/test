const path = require("path");
const src = path.resolve(__dirname, 'public/src')
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const webpack = require("webpack");

require('dotenv').config().parsed;
const env = process.env

const config = {
  target: ["web", "es5"],

  entry: {
    // auth:{
    //   // vendor: path.resolve(src, 'common.js'),
    //   // file
    // },

    admin: path.resolve(src, 'Admin/admin.js'),
    auth: path.resolve(src, 'Auth/auth.js'),
    main: path.resolve(src, 'Main/main.js'),
    cookie: path.resolve(src, 'components/cookie/cookie.js'),
    mainHeader: path.resolve(src, 'components/header/header.js'),
    common: path.resolve(src, 'common.js'),
    list: path.resolve(src, 'components/list/list.js'),
    product: path.resolve(src, 'Product/card.js'),
    dnd: path.resolve(src, 'components/dnd/dnd.js'),
    // breadcrumbs: path.resolve(src, 'components/breadcrumbs.js'),

  },
  output: {
    path: path.resolve(__dirname, "public/dist"),
    filename: '[name].js',
    asyncChunks: true,
    clean: true,
  },



  devServer: {
    allowedHosts: "all",
    host: "localhost",
    // https: true,
    port: 4000,
    hot: true,
    watchFiles: {
      paths: ['public/src/**/*.*'],
    },
    headers: {
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, PATCH, OPTIONS",
      "Access-Control-Allow-Headers": "X-Requested-With, content-type, Authorization"
    }
  },

  plugins: [
    new MiniCssExtractPlugin(
      //   {
      //   filename: devMode ? "dist/[name].css" : "[name].[contenthash].css",
      //   chunkFilename: devMode ? "[id].css" : "[id].[contenthash].css",
      // }
    ),
    new webpack.DefinePlugin({
      'process.env.SU_EMAIL': JSON.stringify(env.SU_EMAIL)
    }),
    new webpack.ProvidePlugin({
      $: path.resolve(path.join(__dirname, 'src/common')),
    }),

  ],

  module: {

    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        use: {
          loader: 'babel-loader',
        }
      },

      {
        test: /\.(?:ico|gif|png|jpg|jpeg|svg|woff|woff2|eot|ttf|otf)$/i,
        type: 'asset/resource',
      },
      // {test: /\.svg/, type: 'asset/inline'},
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {},
          },
          'css-loader',
          'sass-loader',
        ]
      },
    ]
  },
};

module.exports = (env, argv) => {
  console.log('mode:', argv.mode)
  if (argv.mode ==='production') {
    config.devtool = "nosources-source-map"
  } else {
    config.devtool = "source-map"
  }
  return config;
};
