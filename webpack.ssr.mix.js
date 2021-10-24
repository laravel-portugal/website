const path = require('path')
const mix = require('laravel-mix')
const webpackNodeExternals = require('webpack-node-externals')

require('laravel-mix-merge-manifest')

mix.alias({
    ziggy: path.resolve('vendor/tightenco/ziggy/dist'),
});

mix
    .js('resources/js/start.js', 'public/js')
    .vue({ version: 3 })
    .alias({ '@': path.resolve('resources/js') })
    .webpackConfig({
        target: 'node',
        externals: [webpackNodeExternals()],
    })
    .mergeManifest()
