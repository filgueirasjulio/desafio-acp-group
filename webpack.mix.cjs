const mix = require('laravel-mix');

mix
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/auth.scss', 'public/css')
    .sass('resources/sass/components.scss', 'public/css')
    .js('resources/js/bootstrap.js', 'public/js')
    .js('resources/js/app.js', 'public/js')
    .version()
    .sourceMaps(false)
    .webpackConfig({
      module: {
          rules: [
              {
                  test: /\.(woff(2)?|ttf|eot|svg|otf)$/,
                  use: [
                      {
                          loader: 'file-loader',
                          options: {
                              name: 'fonts/[name].[ext]',
                              outputPath: 'fonts',
                              publicPath: '../fonts',
                          },
                      },
                  ],
              },
              {
                  test: /\.(png|jpe?g|gif|svg|webp)$/,
                  use: [
                      {
                          loader: 'file-loader',
                          options: {
                              name: 'images/[name].[ext]',
                              outputPath: 'images',
                              publicPath: '../images',
                          },
                      },
                  ],
              },
          ],
      },
              experiments: {
            outputModule: true,
        },
  });
  