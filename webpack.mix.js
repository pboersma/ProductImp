// webpack.mix.js

let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss'); /* Add this line at the top */

mix.ts('src/productimp/Resources/App.ts', 'src/productimp/Visualization/dist/').vue();
mix.sass('src/productimp/Resources/App.scss', 'src/productimp/Visualization/dist/').options({
    postCss: [ tailwindcss('./tailwind.config.js') ],
});``