// webpack.mix.js

let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss'); /* Add this line at the top */

mix.js('src/productimp/Resources/App.js', 'src/productimp/Visualization/dist/').vue();
mix.sass('src/productimp/Resources/App.scss', 'src/productimp/Visualization/dist/').options({
    postCss: [ tailwindcss('./tailwind.config.js') ],
});``