import path from "path";

import { buildWebpack } from "./config/build/build.webpack";
import type { TEnvVariables } from "./config/build/types";

export default (env: TEnvVariables) => {
	const envMode = env.mode;
	const envPort = Number(env.port);

	const srcPath = path.resolve(__dirname, "src");

	return buildWebpack({
		port: envPort || 5050,
		mode: envMode ?? "production",
		paths: {
			output: path.resolve(__dirname, "dist"),
			entry: {
				main: path.resolve(srcPath, "index.ts"),
			},
			src: srcPath,
		},
	});
};
