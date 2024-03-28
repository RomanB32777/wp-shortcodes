module.exports = {
	extends: [
		"eslint:recommended",
		"plugin:@typescript-eslint/eslint-recommended",
		"plugin:@typescript-eslint/recommended",
		"plugin:prettier/recommended",

		// Extends two more configuration from "import" plugin
		"plugin:import/recommended",
		"plugin:import/typescript",
	],
	plugins: ["import", "@typescript-eslint"],
	parser: "@typescript-eslint/parser",
	rules: {
		"no-shadow": [2, { allow: ["done"] }],
		"prettier/prettier": ["warn"],

		// import rules
		"import/no-cycle": ["error", { ignoreExternal: true, maxDepth: 1 }],
		"import/order": [
			"error",
			{
				pathGroups: [
					{
						pattern: "@/**",
						group: "internal",
						position: "after",
					},
				],
				groups: ["builtin", "external", "internal", ["parent", "sibling"], "index"],
				"newlines-between": "always-and-inside-groups",
				distinctGroup: false,
				pathGroupsExcludedImportTypes: ["builtin"],
			},
		],
		"import/no-duplicates": ["error", { "prefer-inline": true }],
		// turn on errors for missing imports
		"import/no-unresolved": "off",
		// end import rules

		"@typescript-eslint/naming-convention": [
			"error",
			{
				prefix: ["I"],
				selector: "interface",
				format: ["PascalCase"],
			},
			{
				prefix: ["E"],
				selector: "enum",
				format: ["PascalCase"],
			},
			{
				prefix: ["T"],
				selector: "typeAlias",
				format: ["PascalCase"],
			},
			{
				selector: "variable",
				format: ["camelCase", "PascalCase"],
			},
			{
				selector: "enumMember",
				format: ["PascalCase"],
			},
		],
		"@typescript-eslint/consistent-type-imports": ["warn", { prefer: "type-imports" }],
	},
	parserOptions: {
		ecmaVersion: "latest",
	},
	env: {
		browser: true,
		es6: true,
	},
	overrides: [],
};
