import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({

    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
		        'resources/css/tetris-styles.css',
                'resources/css/sass/chat.scss',
                'resources/css/photogallery.css',
                'resources/js/app.js',
                'resources/js/tetris/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
});
