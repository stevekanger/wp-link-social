const path = require("path");
const rootDir = path.join(__dirname, "");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");

module.exports = {
  entry: {
    ["wp-link-social-admin"]: path.join(rootDir, "src/js/", "admin"),
    ["wp-link-social-app"]: path.join(rootDir, "src/js/", "app"),
  },

  output: {
    filename: "[name].js",
    path: path.join(rootDir, "dist"),
    clean: true,
  },

  watchOptions: {
    ignored: ["**/node_modules", "**/dist", "**/node_modules/**", "**/dist/**"],
  },

  module: {
    rules: [
      {
        test: /\.tsx?$/,
        use: "ts-loader",
        exclude: /node_modules/,
      },
      {
        test: /\.s[ac]ss$/i,
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "postcss-loader",
          "sass-loader",
        ],
      },
    ],
  },

  resolve: {
    extensions: [".tsx", ".ts", ".js"],
  },

  plugins: [
    new MiniCssExtractPlugin(),
    new BrowserSyncPlugin({
      proxy: "http://localhost",
      files: ["**/*.php"],
    }),
  ],

  devServer: {
    devMiddleware: {
      writeToDisk: true,
    },
    port: 3001,
  },
};
