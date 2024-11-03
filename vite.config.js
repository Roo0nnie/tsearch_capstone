import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/css/welcome.css",
                "resources/css/welcome_manual.css",
                "resources/js/nav.js",
                "resources/js/announcement.js",
                "resources/js/profile.js",
                "resources/js/user_search.js",
                "resources/js/faculty_search.js",
                "resources/js/guest_search.js",
                "resources/js/imrad_search.js",
                "resources/js/rating.js",
                "resources/js/app.js",
                "resources/js/bootstrap.js",
            ],
            refresh: true,
        }),
    ],
});
