import type { Configuration } from "webpack";

import type { IBuildOptions } from "./types";

export function buildResolvers({ paths }: IBuildOptions): Configuration["resolve"] {
	return {
		extensions: [".ts", ".js"],
		alias: {
			"@": paths.src,
		},
	};
}
