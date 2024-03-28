import path from "path";

import MiniCssExtractPlugin from "mini-css-extract-plugin";
import type { ModuleOptions } from "webpack";

import type { IBuildOptions } from "./types";

export function buildLoaders({ mode }: IBuildOptions): ModuleOptions["rules"] {
	const isProduction = mode === "production";

	const fontLoader = {
		test: /\.(woff|woff2|eot|ttf|otf)$/i,
		type: "asset/resource",
		generator: {
			filename: path.join("fonts", "[name][ext]"),
		},
	};

	const cssLoader = {
		test: /\.css$/i,
		use: [
			MiniCssExtractPlugin.loader,
			{
				loader: "css-loader",
				options: {
					sourceMap: !isProduction,
					modules: {
						auto: true,
					},
				},
			},
			"postcss-loader",
		],
	};

	const sassLoader = {
		test: /\.s[ac]ss$/i,
		use: [...cssLoader.use, "sass-loader"],
	};

	const babelLoader = {
		test: /\.ts?$/,
		exclude: /node_modules/,
		use: {
			loader: "babel-loader",
			options: {
				presets: ["@babel/preset-env", "@babel/preset-typescript"],
			},
		},
	};

	return [fontLoader, cssLoader, sassLoader, babelLoader];
}
