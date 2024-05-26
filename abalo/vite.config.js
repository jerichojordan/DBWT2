import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/css/newarticle.scss','resources/css/articles.scss', 'resources/js/app.js', 'resources/js/cookiecheck.js','resources/js/newArticle.js'],
            refresh: true,
        }),
    ],
    build: {
        minify: false
    }
});
