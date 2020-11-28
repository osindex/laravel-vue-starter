const mix = require('laravel-mix');
const APP_URL = process.env.APP_URL || 'localhost'
mix.webpackConfig({
  resolve: {
	  extensions: ['.js', '.vue', '.json'],
	  alias: {
        '@': path.resolve(__dirname, 'resources/js')
	  },
  },
  output: {
    publicPath: process.env.MIX_PPATH || '/'    
  }
})
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.browserSync({
  proxy: APP_URL,
  files: [
    'resources/js/*',
    'resources/js/*/*',
    'resources/js/*/*/*',
    'resources/js/components/*/*',
    'resources/js/views/admin/*/*',
    'resources/js/views/admin/*/*/*',
    'resources/views/*/*.php'
  ]
})
mix.js('resources/js/app.js', 'public/js')
	.js('resources/js/admin.js', 'public/js')
  .copyDirectory('resources/assets', 'public/assets/')
    .sass('resources/sass/app.scss', 'public/css');
if (mix.config.inProduction) {
  mix.version()
}
