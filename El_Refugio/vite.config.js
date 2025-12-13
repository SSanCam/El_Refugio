import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/css/animals.css',
        'resources/css/dashboard.css',
        'resources/css/forms.css',
        'resources/css/responsive.css',
        'resources/js/app.js',
      ],
      refresh: false,
    }),
  ],
})
