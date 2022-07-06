const path = require("path");
const src = path.resolve(__dirname, 'public/src')
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const webpack = require("webpack");
const isProduction = false;

require('dotenv').config().parsed;
const env = process.env


const config = {
  target: ["web", "es5"],

  entry: {
    // admin: {
    //   import: path.resolve(src, 'Admin/admin.js'),
    //   dependOn: 'common',
    // },
    admin: {
      import: path.resolve(src, 'Admin/admin.js'),
      // dependOn: 'common',
      // filename:'pages/[name][ext]'
    },
    common: path.resolve(src, 'common.js'),
    // admin: path.resolve(src, 'Admin/admin.js'),
    auth: path.resolve(src, 'Auth/auth.js'),
    // test: path.resolve(src, 'Test/test.js'),
    // test_edit: path.resolve(src, 'Test/test-edit.js'),
    main: path.resolve(src, 'Main/main.js'),

  },
  output: {
    path: path.resolve(__dirname, "public/dist"),
    filename:'[name].js',
    clean: true,
  },
  // optimization: {
  //   runtimeChunk: 'single',
  //   splitChunks: {
  //     // chunks: 'all',
  //     // maxInitialRequests: Infinity,
  //     // minSize: 0,
  //     // cacheGroups: {
  //     //   vendor: {
  //     //     test: /[\\/]node_modules[\\/]/,
  //     //     name(module) {
  //     //       // get the name. E.g. node_modules/packageName/not/this/part.js
  //     //       // or node_modules/packageName
  //     //       const packageName = module.context.match(/[\\/]node_modules[\\/](.*?)([\\/]|$)/)[1];
  //     //
  //     //       // npm package names are URL-safe, but some servers don't like @ symbols
  //     //       return `npm.${packageName.replace('@', '')}`;
  //     //     },
  //     //   },
  //     // },
  //   },
  // },


  devServer: {
    allowedHosts: "all",
    host: "localhost",
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

module.exports = () => {
  console.log('isProduction:',isProduction)
  if (isProduction) {
    config.mode = "production";
    config.devtool = "none"
  } else {
    config.mode = "development";
    config.devtool = "source-map"
    // console.log('dev tool = '+config.devtool)
  }
  return config;
};
