module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  extends: [
    'plugin:react/recommended',
    'plugin:react-hooks/recommended',
    'plugin:jsx-a11y/recommended',
    'airbnb',
  ],
  overrides: [
  ],
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: [
    'react',
    'jsx-a11y'
  ],
  rules: {
      "consistent-return": 2,
      "indent"           : [2],
      "no-else-return"   : 1,
      "semi"             : [1, "always"],
      "space-unary-ops"  : 2,
      "max-len"          : 0
  },
};
