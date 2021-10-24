const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-merge-manifest');

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

mix.extend('translations', new class {
    webpackRules() {
        return {
            test: path.resolve(__dirname, './resources/lang/index.js'),
            loader: '@kirschbaum-development/laravel-translations-loader/php',
            options: {
                parameters: "{$1}",
                includeOnly: [
                    'app',
                    'auth',
                    'pagination',
                    'passwords',
                    'users',
                    'placeholders'
                ],
                exclude: [],
            }
        }
    }
});

mix
    .translations()
    .js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.pcss', 'public/css', [
        require('postcss-import'),
        require('postcss-nesting'),
        require('tailwindcss'),
    ])
    .webpackConfig(require('./webpack.config'))
    .copy('resources/img','public/img')
    .mergeManifest();

if (mix.inProduction()) {
    mix.version();
}


