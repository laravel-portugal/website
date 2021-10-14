const path = require('path');

module.exports = {
    output: {
        chunkFilename: 'js/[name].js?id=[chunkhash]',
        path: path.resolve(__dirname, './public')
    },
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
};
