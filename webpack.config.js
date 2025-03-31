const path = require('path');
const glob = require('glob');
const ESLintPlugin = require('eslint-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const RemovePlugin = require('remove-files-webpack-plugin');
const fs = require('fs-extra');

module.exports = (env, argv) => {
	const blocksJs = Object.assign(
		...glob.sync('parts/blocks/**/*.js').map((block) => {
			const name = path.basename(block, '.js').toLowerCase();
			const files = glob.sync(`./parts/blocks/${name}/*.js`);
			if (files.length !== 0) {
				return { [name]: files };
			}
		})
	);
	const userConfig = {
		proxy: {
			dirname: path.basename(__dirname),
			port: '',
		},
		distDirectory: `../${path.basename(__dirname)}-dist/`,
		tmpDirectory: './tmp/',
		distFiles: ['*.php', 'style.css', 'screenshot.jpg', 'inc/', 'parts/', 'vendor/', 'src/', 'dist/'],
	};
	if (env.port == 8890) {
		userConfig.proxy.port = 8890;
	} else {
		userConfig.proxy.dirname = `${path.basename(__dirname)}.local`;
	}
	const webpackConfig = {
		stats: {
			colors: true,
			entrypoints: false,
			env: false,
			hash: false,
			version: false,
			timings: true,
			assets: false,
			chunks: false,
			modules: false,
			reasons: false,
			children: false,
			source: false,
			errors: true,
			errorDetails: true,
			warnings: true,
			publicPath: false,
		},
		entry: {
			main: './src/js/main.js',
			singlePost: './src/js/singlePost.js',
			...blocksJs,
		},
		output: {
			path: path.resolve(__dirname, 'dist'),
			filename: 'js/[name].min.js',
			chunkFilename: 'js/[id].[chunkhash].js',
			publicPath: `/wp-content/themes/${path.basename(__dirname)}/dist/`,
		},
		module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /node_modules/,
					use: {
						loader: 'babel-loader',
						options: {
							presets: ['@babel/preset-env'],
						},
					},
				},
				{
					test: [/\.scss/, /\.css/],
					use: ['css-loader', 'sass-loader'],
				},
			],
		},
		plugins: [
			new RemovePlugin({
				before: {
					allowRootAndOutside: true,
					include: [userConfig.distDirectory],
				},
			}),
			new ESLintPlugin({
				emitWarning: true,
				fix: true,
			}),
			new BrowserSyncPlugin({
				logPrefix: 'webpack',
				files: ['**/*.php', './dist/**/*'],
				host: 'localhost',
				port: 3000,
				proxy: `https://${userConfig.proxy.dirname}:${userConfig.proxy.port}`,
				ghostMode: false,
			}),
		],
		node: false,
	};

	if (argv.mode === 'development') {
		webpackConfig.devtool = 'source-map';
	} else if (argv.mode === 'production') {
		webpackConfig.output.publicPath = `/wp-content/themes/${path.basename(__dirname)}-dist/dist/`;
		webpackConfig.plugins.push({
			apply: (compiler) => {
				compiler.hooks.afterEmit.tapAsync('AfterEmitPlugin', (compilation, callback) => {
					setTimeout(() => {
						userConfig.distFiles.forEach((filePattern) => {
							const filesToCopy = glob.sync(filePattern);
							filesToCopy.forEach((file) => {
								const destination = path.join(userConfig.distDirectory, path.basename(file));
								fs.copySync(file, destination);
							});
							filesToCopy.forEach((file) => {
								const destination = path.join(userConfig.tmpDirectory, path.basename(file));
								fs.copySync(file, destination);
							});
						});
						console.log('Files have been copied to dist directory!');
						callback();
					}, 3000);
				});
			},
		});
	}
	return webpackConfig;
};
