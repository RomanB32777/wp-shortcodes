import ForkTsCheckerWebpackPlugin from "fork-ts-checker-webpack-plugin";
import MiniCssExtractPlugin from "mini-css-extract-plugin";
import {
	DefinePlugin,
	HotModuleReplacementPlugin,
	ProgressPlugin,
	type Configuration,
} from "webpack";

import type { IBuildOptions } from "./types";

export function buildPlugins({ mode }: IBuildOptions): Configuration["plugins"] {
	const isDev = mode === "development";

	const plugins: Configuration["plugins"] = [
		new ProgressPlugin(),
		new DefinePlugin({
			__ENV__: JSON.stringify(mode),
		}),
		new MiniCssExtractPlugin({
			filename: "css/[name].css",
			chunkFilename: "css/[name].css",
		}),
	];

	if (isDev) {
		plugins.push(new HotModuleReplacementPlugin(), new ForkTsCheckerWebpackPlugin());
	}

	return plugins;
}
