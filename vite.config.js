import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Bootstrapのパスを追加
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // node_modulesフォルダの中にインストールされたBootstrapのパスを追加
    resolve: {
        alias:{
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
});
