const path = require("path");
const src = path.resolve(__dirname, 'public/src')
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const webpack = require("webpack");
const isProduction = false;
const env = require('dotenv').config().parsed;

const devMode = env.MODE === 'production'

const config = {

  entry: {
    admin: path.resolve(src, 'Admin/admin.js'),
    auth: path.resolve(src, 'Auth/auth.js'),
    // test: path.resolve(src, 'Test/test.js'),
    // test_edit: path.resolve(src, 'Test/test-edit.js'),
    main: path.resolve(src, 'Main/main.js'),

  },
  output: {
    // filename:[name].js,
    // chunkFilename:[name].js,
    // assetModuleFilename: 'assets/[hash][ext][query]',
    path: path.resolve(__dirname, "public/dist"),
  },


  devServer: {
    allowedHosts: "all",
    host: "localhost",
    port: 4000,
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
            options: {
            },
          },
          'css-loader',
          'sass-loader',
        ]
      },
    ]
  },
};

module.exports = () => {
  if (isProduction) {
    config.mode = "production";
    config.devtool = "none"
  } else {
    config.mode = "development";
    // config.devtool = "eval-source-map"
    // config.devtool = "eval"
    // config.devtool = "eval-cheap-source-map"
    config.devtool = "eval-cheap-module-source-map"
    // console.log('dev tool = '+config.devtool)
  }
  return config;
};
