import path from "path";

import type { Configuration as DevServerConfiguration } from "webpack-dev-server";

import type { IBuildOptions } from "./types";

export function buildDevServer({ port, paths }: IBuildOptions): DevServerConfiguration {
	return {
		static: {
			directory: paths.output,
			staticOptions: {},
			watch: true,
			publicPath: "/build/app/",
		},
		devMiddleware: {
			writeToDisk: true,
		},
		compress: true,
		open: false,
		hot: true,
		port: port || 5050,
		allowedHosts: "all",
		watchFiles: {
			paths: [
				paths.src,
				path.resolve(__dirname, "theme-functions"),
				path.resolve(__dirname, "theme-parts"),
			],
		},
	};
}
