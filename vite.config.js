import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/nav.js",
                "resources/js/announcement.js",
                "resources/js/profile.js",
                "resources/js/user_search.js",
                "resources/js/faculty_search.js",
                "resources/js/guest_search.js",
                "resources/js/imrad_search.js",
                "resources/js/rating.js",
            ],
            refresh: true,
        }),
    ],
});
