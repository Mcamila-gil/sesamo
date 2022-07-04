module.exports = {
	globDirectory: '.',
	globPatterns: [
		'**/*.{php,css,png,js,json,sql}'
	],
	swDest: 'sw.js',
	ignoreURLParametersMatching: [
		/^utm_/,
		/^fbclid$/
	]
};