const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');
const path = require("path");

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
    .js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.pcss', 'public/css', [
        require('postcss-import'),
        require('postcss-nesting'),
        require('tailwindcss'),
    ])
    .webpackConfig(require('./webpack.config'))
    .copy('resources/img','public/img')
    .translations()
    .mergeManifest();

if (mix.inProduction()) {
    mix.version();
}


