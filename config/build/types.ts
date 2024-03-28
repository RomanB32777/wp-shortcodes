export type TEntryPaths = "main";

export interface IBuildPaths {
	entry: Record<TEntryPaths, string>;
	output: string;
	src: string;
}

export type TBuildMode = "production" | "development";

export interface IBuildOptions {
	mode: TBuildMode;
	port: number;
	paths: IBuildPaths;
}

export type TEnvVariables = Partial<Omit<IBuildOptions, "paths">>;
