import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: false, // en producción no hace falta hot reload
        }),
    ],

    build: {
        outDir: 'public/build',
        manifest: true,
        emptyOutDir: true, // limpia builds anteriores
    },
});
