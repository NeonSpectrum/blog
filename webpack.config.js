const path = require('path');

module.exports = {
    module: {
        rules: [
            {
                test: /\.ts$/,
                exclude: /node_modules/,
                use: [
                    { loader: 'cache-loader' },
                    {
                        loader: 'babel-loader',
                        options: { cacheDirectory: true }
                    },
                    {
                        loader: 'ts-loader',
                        options: {
                            appendTsSuffixTo: [/\.vue$/]
                        }
                    }
                ]
            }
        ]
    },
    resolve: {
        extensions: ['.js', '.json', '.ts'],
        alias: {
            '@': path.resolve('resources/js/src')
        }
    }
};
