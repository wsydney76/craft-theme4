const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');
const devMode = process.env.NODE_ENV !== 'production';
const path = require('path');
const sane = require('sane');

config = {
    optimization: {
        minimizer: devMode ? [] : [
            new TerserJSPlugin(),
            new OptimizeCSSAssetsPlugin()
        ],
    },
    devServer: {
        contentBase: path.join(__dirname, 'web/assets/dist'),
        writeToDisk: true,
        port: 8080,
        hot: true,
        disableHostCheck: true,
        before: (app, server) => {
            const watcher = sane(path.join(__dirname, './templates/'), {
                glob: ['**/*'],
            });
            watcher.on('change', function (filePath, root, stat) {
                console.log('  File modified:', filePath);
                server.sockWrite(server.sockets, "content-changed");
            });
        }
    },
    output: {
        path: path.resolve(__dirname, 'web/assets/dist'),
        filename: devMode ? "[name].js" : "[name].[hash].js",
        chunkFilename: "[name].[hash].js",
        publicPath: '/assets/dist/'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: {
                    loader: "babel-loader"
                }
            }
        ]
    },
    plugins: [
        new CleanWebpackPlugin(),
        new ManifestPlugin(),
        new MiniCssExtractPlugin({
            filename: devMode ? '[name].css' : '[name].[hash].css',
            chunkFilename: devMode ? '[id].css' : '[id].[hash].css',
        })
    ]
}

module.exports = (env, argv) => {
    if (argv.hot) {
        config.module.rules.push({
            test: /\.scss$/,
            use: [
                "style-loader",
                "css-loader",
                "postcss-loader",
                "sass-loader"
            ]
        });
    } else {
        config.module.rules.push({
            test: /\.scss$/,
            use: [
                MiniCssExtractPlugin.loader,
                "css-loader",
                "postcss-loader",
                "sass-loader"
            ]
        });
    }

    return config;
};
