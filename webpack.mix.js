// webpack.mix.js

let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss'); /* Add this line at the top */

mix.js('src/lmwcwppi/Resources/App.js', 'src/lmwcwppi/Visualization/dist/').vue();
mix.sass('src/lmwcwppi/Resources/App.scss', 'src/lmwcwppi/Visualization/dist/').options({
    postCss: [ tailwindcss('./tailwind.config.js') ],
});``