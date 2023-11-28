const path = require("path");
const src = path.resolve(__dirname, 'public/src');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const webpack = require("webpack");

require('dotenv').config().parsed;
const env = process.env;

const config = {
  target: "web",

  entry: {
    // auth:{
    //   // vendor: path.resolve(src, 'common.js'),
    //   // file
    // },

    admin: path.resolve(src, 'Admin/admin.js'),
    bot: path.resolve(src, 'bot/js/app.js'),
    auth: path.resolve(src, 'Auth/auth.js'),
    main: path.resolve(src, 'Main/main.js'),
    cookie: path.resolve(src, 'components/cookie/cookie.js'),
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
    // publicPath: "/assets/",
    clean: true,
  },


  devServer: {
    allowedHosts: "all",
    host: "localhost",
    server: 'https',
    port: 4000,

    // hot: true,
    liveReload: true,
    static: {
      directory: path.join(__dirname, 'public', 'dist'),
    },
    client: {
      logging: 'info',
      // progress: true,
      webSocketTransport: 'ws',
      overlay: true,
    },
    webSocketServer: 'ws',
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
        use: [
          // 'source-map-loader',
          {
            loader: 'babel-loader',
          },
        ]
      },

      {
        test: /\.(?:ico|gif|png|jpg|jpeg|svg|woff|woff2|eot|ttf|otf)$/i,
        type: 'asset/resource',
      },
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
  console.log('mode:', argv.mode);
  if (argv.mode === 'production') {
    // config.devtool = "nosources-source-map"
    config.devtool = "source-map"
  } else {
    config.devtool = "source-map"
  }
  return config;
};
