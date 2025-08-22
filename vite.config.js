import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/admin-attendance-index.js",
                "resources/js/admin-events-index.js",
                "resources/js/admin-events-create.js",
                "resources/js/admin-attendance-check-in.js",
                "resources/js/admin-members-index.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
