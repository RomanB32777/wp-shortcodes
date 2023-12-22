const postcssPresetEnv = require("postcss-preset-env");

const autoprefixer = require("autoprefixer");

module.exports = {
	plugins: [postcssPresetEnv({ browsers: "last 2 versions" }), autoprefixer],
};
