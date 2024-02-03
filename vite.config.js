import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

const path = require('path');

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/participate.js',
                'resources/js/filter-search.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            // 追記
            '$': 'jQuery',
        }
    }, 
});
