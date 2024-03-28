const postcssPresetEnv = require("postcss-preset-env");

const tailwindcss = require("tailwindcss");

const autoprefixer = require("autoprefixer");

const tailwindConfig = require("./tailwind.config.js");

module.exports = {
	plugins: [
		postcssPresetEnv({ browsers: "last 2 versions" }),
		tailwindcss,
		tailwindConfig,
		autoprefixer,
	],
};
