import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin';
import critical from 'rollup-plugin-critical';
// Déterminez l'URL selon l'environnement
const siteUrl = process.env.NODE_ENV === 'production' 
    ? 'https://blog.gaelgerard.com' 
    : 'http://w3.gg';

export default defineConfig({
  base: '/app/themes/w3-sage/public/build/',
  plugins: [
    tailwindcss(),
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/editor.css',
        'resources/js/editor.js',
      ],
      refresh: true,
    }),

    wordpressPlugin(),

    // Generate the theme.json file in the public/build/assets directory
    // based on the Tailwind config and the theme.json file from base theme folder
    wordpressThemeJson({
      disableTailwindColors: false,
      disableTailwindFonts: false,
      disableTailwindFontSizes: false,
    }),
    // Ajout du plugin Critical
    critical({
      criticalUrl: siteUrl, // L'URL de votre blog Bedrock
      criticalBase: 'public/build',
      criticalPages: [
        { uri: '/', template: 'index' }, // La home
        { uri: '/wordpress-cms/creation-de-plateforme-de-cours-en-ligne-wordpress-retour-dexperience-et-choix-techniques', template: 'single' }, // Un article pour le LCP
      ],
      criticalConfig: {
        width: 1300,
        height: 900,
      },
    }),
  ],
  resolve: {
    alias: {
      '@scripts': '/resources/js',
      '@styles': '/resources/css',
      '@fonts': '/resources/fonts',
      '@images': '/resources/images',
    },
  },
})
