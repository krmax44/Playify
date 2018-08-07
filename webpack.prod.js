const merge = require('webpack-merge');
const common = require('./webpack.common.js');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ZipPlugin = require('zip-webpack-plugin');

module.exports = merge(common, {
	mode: 'production',
	plugins: [
		new CopyWebpackPlugin(['src/key.pem']),
		new ZipPlugin({
			filename: 'build.zip'
		})
	]
});