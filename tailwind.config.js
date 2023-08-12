import colors from 'tailwindcss/colors'
import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import aspectRatio from '@tailwindcss/aspect-ratio'

/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  presets: [
    require('./vendor/shopper/framework/tailwind.config'),
  ],
  content: [
    './resources/**/*.blade.php',
    './vendor/shopper/**/*.php',
    './storage/framework/views/*.php',

    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/filament/**/*.blade.php',
    './vendor/shopper/framework/**/*.blade.php',
    './vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php',
    './vendor/wire-elements/modal/resources/views/*.blade.php',
    './vendor/wireui/wireui/resources/**/*.blade.php',
    './vendor/wireui/wireui/ts/**/*.ts',
    './vendor/wireui/wireui/src/View/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: colors.blue,
        indigo: colors.blue,
        secondary: colors.slate,
        gray: colors.slate,
        success: colors.emerald,
        warning: colors.yellow,
      },
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
        heading: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    }
  },
  plugins: [forms, typography, aspectRatio],
}
