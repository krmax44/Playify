const webpack = require('webpack');
const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');

module.exports = {
  mode: 'development',
  entry: {
    popup: path.join(__dirname, 'src/js/Popup.js'),
    custom: path.join(__dirname, 'src/js/SetupCustom.js'),
    background: path.join(__dirname, 'src/js/Background.js'),
    director: path.join(__dirname, 'src/js/Director.js')
    //options: path.join(__dirname, 'src', 'js', 'options.js'),
    //background: path.join(__dirname, 'src', 'js', 'background.js')
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      },
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/
      },
      {
        test: /\.(png|jpg|gif|svg|woff2)$/,
        loader: 'file-loader',
        options: {
          name: '[name].[ext]?[hash]'
        }
      },
      {
        test: /\.scss$/,
        use: [
          'vue-style-loader',
          'css-loader',
          {
            loader: 'sass-loader'
          }
        ]
      },
      {
        test: /\.css$/,
        use: [ 'style-loader', 'css-loader' ]
      }
    ]
  },
  plugins: [
    new CleanWebpackPlugin(['dist/*.*']),
    new VueLoaderPlugin(),
    new HtmlWebpackPlugin({
      filename: 'popup.html',
      template: 'src/template.html',
      chunks: ['popup']
    }),
    new HtmlWebpackPlugin({
      filename: 'custom.html',
      template: 'src/template.html',
      chunks: ['custom']
    }),
    new HtmlWebpackPlugin({
      filename: 'index.html',
      template: 'src/template.html',
      chunks: ['director']
    }),
    new CopyWebpackPlugin([{
      from: 'src/manifest.json',
      transform: content => Buffer.from(JSON.stringify({
        description: process.env.npm_package_description,
        version: process.env.npm_package_version,
        ...JSON.parse(content.toString())
      }))
    }, { from: 'src/static/', to: 'static/' }, 'key.pem'])
  ]
};