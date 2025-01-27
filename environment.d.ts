declare global {
	namespace NodeJS {
		// eslint-disable-next-line @typescript-eslint/naming-convention
		interface ProcessEnv {
			PRIMARY_COLOR: string;
			PRIMARY_GRIZZLY_COLOR: string;
			PRIMARY_LIGHT_COLOR: string;
			PRIMARY_BRIGHTEST_COLOR: string;
			SECONDARY_COLOR: string;
			SECONDARY_LIGHT_COLOR: string;
			DARK_COLOR: string;
			DARK_GRIZZLY_COLOR: string;
			DARK_OPACITY_COLOR: string;
			WHITE_COLOR: string;
			WHITE_LIGHT_COLOR: string;
			WHITE_OPACITY_COLOR: string;
			WHITE_STANDARD_COLOR: string;
			GRIZZLY_COLOR: string;
			GRIZZLY_LIGHT_COLOR: string;
			GRIZZLY_DARK_COLOR: string;
		}
	}
}

export {};
