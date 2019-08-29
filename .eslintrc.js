module.exports = {
	extends: ['eslint:recommended', 'plugin:vue/essential', 'prettier'],
	env: {
		browser: true,
		node: true
	},
	plugins: ['prettier'],
	rules: {
		'prettier/prettier': 'error',
		'no-console': 'off',
		'no-case-declarations': 'off',
		'no-unused-vars': [
			1,
			{
				ignoreSiblings: true,
				argsIgnorePattern: 'e'
			}
		]
	},
	globals: {
		chrome: 'readonly'
	}
};
