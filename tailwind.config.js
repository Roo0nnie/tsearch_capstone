/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/View/Components/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    maroon: "#800000",
                    "maroon-hover": "#991b1b",
                    gold: "#f6c453",
                    ink: "#1f2937",
                    muted: "#6b7280",
                    surface: "#f5f7fb",
                },
            },
            fontFamily: {
                sans: ["Nunito", "Public Sans", "ui-sans-serif", "system-ui", "sans-serif"],
            },
            boxShadow: {
                shell: "0 12px 35px rgba(15, 23, 42, 0.08)",
                panel: "0 8px 24px rgba(15, 23, 42, 0.08)",
            },
        },
    },
    plugins: [],
};
