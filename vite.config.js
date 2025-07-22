import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // This server block forces Vite to use the correct IPv4 address
    // that all browsers can understand.
    server: {
        host: '127.0.0.1',
    },
});