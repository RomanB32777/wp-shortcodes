import CssMinimizerPlugin from "css-minimizer-webpack-plugin";
import TerserPlugin from "terser-webpack-plugin";
import type { Configuration } from "webpack";

import { buildDevServer } from "./build.server";
import { buildLoaders } from "./build.loaders";
import { buildPlugins } from "./build.plugins";
import { buildResolvers } from "./build.resolvers";
import type { IBuildOptions } from "./types";

export function buildWebpack(options: IBuildOptions): Configuration {
	const { mode, paths } = options;

	const isProduction = mode === "production";

	const config: Configuration = {
		mode: mode ?? "development",
		entry: paths.entry,
		output: {
			path: paths.output,
			filename: "js/[name].js",
			clean: isProduction,
		},
		plugins: buildPlugins(options),
		module: {
			rules: buildLoaders(options),
		},
		resolve: buildResolvers(options),
		devtool: isProduction ? "source-map" : "eval-cheap-module-source-map",
		devServer: isProduction ? undefined : buildDevServer(options),
	};

	if (isProduction) {
		config.optimization = {
			splitChunks: {
				cacheGroups: {
					swiper: {
						chunks: "all",
						test: /[\\/]node_modules[\\/]swiper[\\/]/,
						name: "swiper",
					},
				},
			},
			minimizer: [
				new CssMinimizerPlugin(),
				new TerserPlugin({ terserOptions: { keep_fnames: true } }),
			],
		};
	}

	return config;
}
