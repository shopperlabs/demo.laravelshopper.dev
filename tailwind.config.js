import colors from 'tailwindcss/colors'
import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
import aspectRatio from '@tailwindcss/aspect-ratio'
import preset from './vendor/filament/support/tailwind.config.preset';

/** @type {import('tailwindcss').Config} */
export default {
  presets: [preset],
  content: [
    './storage/framework/views/*.php',
    './app/Filament/**/*.php',
    './resources/views/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
    './vendor/laravelcm/livewire-slide-overs/resources/views/*.blade.php',
    './vendor/wire-elements/modal/resources/views/*.blade.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],

  theme: {
    extend: {
      colors: {
        primary: colors.blue,
      },
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
        heading: ['Figtree', ...defaultTheme.fontFamily.mono],
      },
      maxWidth: {
        '8xl': '92rem',
      }
    },
  },

  plugins: [forms, typography, aspectRatio],
}
