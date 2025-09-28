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
                "resources/js/admin-attendance-create.js",
                "resources/js/admin-members-index.js",
                "resources/js/admin-reports-index.js",
                "resources/js/admin-officers-index.js",
                "resources/js/admin-notification-create.js",
                "resources/js/admin-notification-index.js",
                "resources/js/member-my-event.js",
                "resources/js/admin-sermon-create.js",
                "resources/js/admin-tasks-index.js",
                "resources/js/admin-tasks-create.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
