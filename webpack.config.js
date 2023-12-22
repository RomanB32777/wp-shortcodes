const path = require("path");
const webpack = require("webpack");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const scssFiles = [
	"shortcode-custom-3",
	"shortcode-custom-4",
	"shortcode-custom-table",
];

module.exports = {
	mode: "production", // production | development
	entry: {
		...scssFiles.reduce((entry, fileName) => {
			entry[fileName] = path.resolve(__dirname, "scss", `${fileName}.scss`);
			return entry;
		}, {}),
	},
	output: {
		path: path.resolve(__dirname, "build"),
		filename: "[name].js",
		clean: true,
	},
	plugins: [
		new webpack.ProgressPlugin(),
		new MiniCssExtractPlugin({
			filename: "../css/[name].css",
		}),
	],
	module: {
		rules: [
			{
				test: /\.s[ac]ss$/i,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: "css-loader",
						options: { url: false },
					},
					"postcss-loader",
					"sass-loader",
				],
			},
		],
	},
	devServer: {
		port: 5050,
		open: false,
		hot: true,
		historyApiFallback: true,
		watchFiles: {
			paths: path.resolve(__dirname, "src"),
			options: {
				usePolling: true,
			},
		},
	},
};
