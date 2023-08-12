const mix = require('laravel-mix')

mix.disableSuccessNotifications()

mix.js('resources/js/app.js', 'public/js')
mix.postCss('resources/css/app.css', 'public/css', [
  require('tailwindcss'),
]).options({ processCssUrls: false })

if (mix.inProduction()) {
  mix.version()
}
