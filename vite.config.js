import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
// https://dreamspos.dreamguystech.com/html/template/productlist.html
// https://bootstrapmade.com/demo/NiceAdmin/
