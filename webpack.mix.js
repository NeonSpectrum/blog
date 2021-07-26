const mix = require('laravel-mix');
const packages = require('./package.json');
const config = require('./webpack.config');

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

mix.webpackConfig(config);

mix.js('resources/js/app.ts', 'public/js').vue()
   .sass('resources/css/app.scss', 'public/css')
   .extract(packages.dependencies)
   .version();
