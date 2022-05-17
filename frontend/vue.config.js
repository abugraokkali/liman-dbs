const webpack = require('webpack');
const TerserPlugin = require('terser-webpack-plugin');
const isProd = process.env.NODE_ENV === "production";

module.exports = {
  productionSourceMap: false,
  outputDir: isProd ? '../public' : '../public/js',
  filenameHashing: false,
  css: {
    extract: false,
  },
  chainWebpack: config => {
    config.plugins.delete('html');
    config.plugins.delete('preload');
    config.plugins.delete('prefetch');
    config.plugins.delete('hmr');
  },
  configureWebpack: {
    mode: isProd ? 'production' : 'development',
    optimization: {
      splitChunks: false,
      minimize: isProd ? true : false,
      minimizer: [new TerserPlugin({
        terserOptions: {
          parallel: true,
          warnings: false,
          mangle: true,
          module: false,
          compress: { drop_console: true },
          output: { comments: false, beautify: false }
        },
      })]
    },
    plugins: [
      new webpack.optimize.LimitChunkCountPlugin({
          maxChunks: 1
      })
    ]
  },
};