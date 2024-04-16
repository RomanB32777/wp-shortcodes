/** @type {import('tailwindcss').Config} */

require("dotenv").config({ path: "./.env" });

const {
	PRIMARY_COLOR,
	PRIMARY_GRIZZLY_COLOR,
	PRIMARY_LIGHT_COLOR,
	PRIMARY_BRIGHTEST_COLOR,
	SECONDARY_COLOR,
	SECONDARY_LIGHT_COLOR,
	DARK_COLOR,
	DARK_GRIZZLY_COLOR,
	DARK_OPACITY_COLOR,
	WHITE_COLOR,
	WHITE_LIGHT_COLOR,
	WHITE_OPACITY_COLOR,
	WHITE_STANDARD_COLOR,
	GRIZZLY_COLOR,
	GRIZZLY_LIGHT_COLOR,
	GRIZZLY_DARK_COLOR,
} = process.env;

const alternativeFonts = ["Arial", "sans-serif"];

module.exports = {
	content: ["./src/**/*.{php,js,ts,tsx}", "./parts/**/*.{php,js,ts,tsx}", "./*.php"],
	theme: {
		extend: {
			colors: {
				primary: {
					DEFAULT: PRIMARY_COLOR || "#17946d",
					grizzly: PRIMARY_GRIZZLY_COLOR || "#a5d6c6",
					light: PRIMARY_LIGHT_COLOR || "#ceede3",
					brightest: PRIMARY_BRIGHTEST_COLOR || "#f1fbf8",
				},
				secondary: {
					DEFAULT: SECONDARY_COLOR || "#f9b002",
					light: SECONDARY_LIGHT_COLOR || "#e3ae6f",
				},
				dark: {
					DEFAULT: DARK_COLOR || "#121212",
					grizzly: DARK_GRIZZLY_COLOR || "#4e4e53",
					opacity: DARK_OPACITY_COLOR || "#000c",
				},
				white: {
					DEFAULT: WHITE_COLOR || "#fff",
					light: WHITE_LIGHT_COLOR || "#f0eff8",
					opacity: WHITE_OPACITY_COLOR || "#f2eff833",
					standard: WHITE_STANDARD_COLOR || "#fff",
				},
				grizzly: {
					DEFAULT: GRIZZLY_COLOR || "#4e4e4e",
					light: GRIZZLY_LIGHT_COLOR || "#7f8c8d",
					dark: GRIZZLY_DARK_COLOR || "#353535",
				},
			},
			fontFamily: {
				roboto: ['"Roboto"', ...alternativeFonts],
				notoSans: ['"NotoSans"', ...alternativeFonts],
				lineSeedJp: ['"LINESeedJP"', ...alternativeFonts],
				inter: ['"Inter"', ...alternativeFonts],
			},
			letterSpacing: {
				wide: "0.75rem",
				widest: "1.5rem",
			},
			spacing: {
				"50%": "50%",
			},
		},
	},
	variants: {
		extend: {},
	},
	plugins: [],
};
