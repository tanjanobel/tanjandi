const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const webpack = require('webpack');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = (env, argv) => {
  const isProduction = argv.mode === 'production';
  const proxyTarget = process.env.WP_PROXY || 'http://localhost:8888'; // Nutze Umgebungsvariable oder Standard
  const proxyHost = new URL(proxyTarget).host.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');

  return {
    entry: {
      app: ['./src/js/app.js', './src/scss/app.scss']
    },
    output: {
      path: path.resolve(__dirname, '.'),
      filename: '[name].js',
      clean: false, // Don't clean the root as it contains PHP files
    },
    devtool: isProduction ? false : 'source-map',
    watchOptions: {
      poll: 1000, // Check for changes every second
      ignored: /node_modules/,
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env']
            }
          }
        },
        {
          test: /\.scss$/,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader',
              options: {
                url: false, // Don't process URLs in CSS (fonts/images)
              }
            },
            {
              loader: 'postcss-loader',
              options: {
                postcssOptions: {
                  plugins: [
                    require('autoprefixer')
                  ]
                }
              }
            },
            {
              loader: 'sass-loader',
              options: {
                api: 'modern',
                sassOptions: {
                  includePaths: [path.resolve(__dirname, 'src/scss')],
                },
                additionalData: (content, loaderContext) => {
                  const { resourcePath } = loaderContext;
                  const scssPath = path.resolve(__dirname, 'src/scss');
                  const relativePath = path.relative(scssPath, resourcePath);

                  const ignoreFiles = [
                    'global.scss', '_global.scss',
                    'settings.scss', '_settings.scss',
                    'util/functions.scss', 'util/_functions.scss',
                    'util/mixins.scss', 'util/_mixins.scss',
                    'util/breakpoints-settings.scss', 'util/_breakpoints-settings.scss'
                  ];

                  if (ignoreFiles.includes(relativePath.replace(/\\/g, '/'))) {
                    return content;
                  }

                  // LOG ZUM DEBUGGEN
                  // process.stdout.write(`>>> PROCESSING: ${resourcePath}\n`);

                  // Wir nutzen einen relativen Pfad zu global.scss
                  const depth = relativePath.split(/[\\/]/).length - 1;
                  const prefix = depth > 0 ? '../'.repeat(depth) : './';
                  const globalImport = `@use "${prefix}global" as *;`;

                  if (content.includes('global" as *') || content.includes("global' as *")) {
                    return content;
                  }

                  return `${globalImport}\n${content}`;
                },
              }
            }
          ]
        }
      ]
    },
    optimization: {
      minimize: isProduction,
      minimizer: [
        new TerserPlugin(),
        new CssMinimizerPlugin({
          minimizerOptions: {
            preset: [
              'default',
              {
                discardComments: { removeAll: false },
              },
            ],
          },
        }),
        new webpack.BannerPlugin({
          banner: `/*\nTheme Name: Tanjandi\nAuthor: Your Name\nVersion: 1.0.0\nText Domain: tanjandi\n*/\n`,
          raw: true,
          entryOnly: false,
          include: /style\.css$/
        }),
      ],
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: 'style.css'
      }),
      new BrowserSyncPlugin({
        proxy: proxyTarget,
        // BrowserSync's own link rewriting corrupts URLs inside inline JSON
        // when they end at an escaped quote (...orders/\"): it swallows the
        // backslash and the script becomes invalid. WooCommerce's checkout
        // settings contain such a URL, which left the checkout without its
        // script on the proxy port. This rule runs first and points every
        // URL of the proxied host at the proxy itself, so the built-in rule
        // finds nothing left to rewrite.
        rewriteRules: [
          {
            match: new RegExp(`https?:(\\\\?/\\\\?/)${proxyHost}`, 'g'),
            fn: (req, res, match) => match.replace(/^https?:/, 'http:').replace(/[^/\\]+$/, req.headers.host),
          },
        ],
        host: '0.0.0.0', // Erlaubt Zugriff von anderen Geräten im Netzwerk
        port: 3000,
        files: [
          '**/*.php',
          './style.css',
          './app.js'
        ],
        injectChanges: true,
        notify: false,
        open: false // Verhindert automatisches Öffnen, falls gewünscht
      })
    ],
    stats: {
      children: true
    }
  };
};
