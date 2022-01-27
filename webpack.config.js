// Generated using webpack-cli https://github.com/webpack/webpack-cli
const path = require("path");
const src = path.resolve(__dirname, 'public/src')
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const isProduction = false;

const config = {

  entry: {
    admin: path.resolve(src, 'Admin/admin.js'),
    // adminCategory: path.resolve(src, 'Adm_catalog/adm_category.js'),
    cabinet: path.resolve(src, 'Auth/cabinet.js'),
    auth: path.resolve(src, 'Auth/auth.js'),
    // freeTest: path.resolve(src, 'Freetest/free-test.js'),
    test: path.resolve(src, 'Test/test.js'),
    test_edit: path.resolve(src, 'Test/test-edit.js'),
    main: path.resolve(src, 'Main/main.js'),
  },

  output: {
    // assetModuleFilename: 'assets/[hash][ext][query]',
    path: path.resolve(__dirname, "public/dist"),
  },


  devServer: {
    allowedHosts: "all",
    // open: true,
    host: "localhost",
    port: 4000,
    // http2: true,
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
    new MiniCssExtractPlugin(),
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
      {test: /\.(sa|sc|c)ss$/, use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader',]},
    ]
  },
};

module.exports = () => {
  if (isProduction) {
    config.mode = "production";
    config.devtool = "none"
  } else {
    config.mode = "development";
    config.devtool = "eval-source-map"
  }
  return config;
};
