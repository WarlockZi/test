exports.default = {

  ignorePatterns: ['.eslintrc.mjs'],
  rules: {
    quotes: ["error", "double"],  // Использовать двойные кавычки.
    semi: ["error", "always"],  // Всегда добавлять точку с запятой в конце утверждения.
    indent: ["error", 2],  // Отступ — это два пробела.
    "no-console": "error"  // Избегать использования в коде методов на консоли (`console`).
  },
  ecmaVersion: 6,
}
