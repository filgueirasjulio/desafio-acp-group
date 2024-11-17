import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/css/auth.css', 
        'resources/js/app.js'
      ],
      refresh: true,
    }),
    vue({
      template: {
        compilerOptions: {
          isCustomElement: (tag) => tag.startsWith('x-')
        }
      }
    }),
  ],
});
