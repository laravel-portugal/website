const path = require('path')
const mix = require('laravel-mix')
const webpackNodeExternals = require('webpack-node-externals')
require('laravel-mix-merge-manifest')

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


mix.alias({
    ziggy: path.resolve('vendor/tightenco/ziggy/dist'),
});

mix
    .translations()
    .js('resources/js/start.js', 'public/js')
    .vue({ version: 3 })
    .alias({ '@': path.resolve('resources/js') })
    .webpackConfig({
        target: 'node',
        externals: [webpackNodeExternals()],
    })
    .mergeManifest()
