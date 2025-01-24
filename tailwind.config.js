/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './node_modules/flowbite/**/*.js',
  ],
  theme: {
    extend: {
      spacing: {
        128: '32rem',
        144: '36rem',
      },
      borderRadius: {
        '4xl': '2rem',
      },
    },
    colors: {
      ...colors,
      primary: '#b71743',
      secondary: '#e38a1d',
      tertiary: '#853286',
      orange: '#d7324b',
      gray: '#e5e5e5',
      white: '#fff',
      black: '#2d2d2d',
      red: '#c53030',
    },
    fontFamily: {
      nunito: ['Nunito', 'sans-serif'],
    },
    fontSize: {
      xs: '.75rem',
      sm: '.875rem',
      base: '1rem',
      lg: '1.125rem',
      xl: '1.25rem',
    },
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
  },
  plugins: ['prettier-plugin-tailwindcss', require('flowbite/plugin')],
}
