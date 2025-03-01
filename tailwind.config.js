/** @type {import('tailwindcss').Config} */
import presets from ".vendor/filament/support/tailwind.config.preset";

module.exports = {
    presets: [presets],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
