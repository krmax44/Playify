const HtmlWebpackPlugin = require('html-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');


module.exports = {
	entry: {
		popup: './src/js/Popup.js',
		custom: './src/js/SetupCustom.js',
		background: './src/js/Background.js',
		director: './src/js/Director.js'
	},
	output: {
		filename: '[name].js',
		publicPath: '/'
	},
	module: {
		rules: [
			{
				test: /\.vue$/,
				loader: 'vue-loader'
			},
			{
				test: /\.js$/,
				loader: 'babel-loader'
			},
			{
				test: /\.(png|jpg|gif|svg|woff2)$/,
				loader: 'file-loader',
				options: {
					name: '[name].[ext]'
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
				use: ['style-loader', 'css-loader']
			}
		]
	},
	plugins: [
		new CleanWebpackPlugin(),
		new VueLoaderPlugin(),
		new HtmlWebpackPlugin({
			filename: 'popup.html',
			template: 'src/template.html',
			chunks: ['popup', 'commons']
		}),
		new HtmlWebpackPlugin({
			filename: 'custom.html',
			template: 'src/template.html',
			chunks: ['custom', 'commons']
		}),
		new HtmlWebpackPlugin({
			filename: 'index.html',
			template: 'src/template.html',
			chunks: ['director', 'commons']
		}),
		new CopyWebpackPlugin([
			{
				from: 'src/manifest.json',
				transform: content =>
					Buffer.from(
						JSON.stringify({
							description: process.env.npm_package_description,
							version: process.env.npm_package_version,
							...JSON.parse(content.toString())
						})
					)
			},
			{ from: 'src/static/', to: 'static/' }
		])
	],
	optimization: {
		splitChunks: {
			cacheGroups: {
				commons: {
					name: 'commons',
					chunks(chunk) {
						return chunk.name !== 'background';
					},
					minChunks: 1
				}
			}
		},
		minimize: true,
		minimizer: [new UglifyJsPlugin()]
	}
};
