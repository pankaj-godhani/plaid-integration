const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')
const path = require('path')
require('laravel-mix-blade-reload')
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js('resources/js/app.js', 'public/js')
  .js('node_modules/flowbite/dist/flowbite.js', 'public/js/flowbite')
  .js('node_modules/flowbite/dist/datepicker.js', 'public/js/flowbite')
  .sass('resources/sass/app.scss', 'public/css')
  .options({
    postCss: [tailwindcss('./tailwind.config.js')],
  })
  .bladeReload()
