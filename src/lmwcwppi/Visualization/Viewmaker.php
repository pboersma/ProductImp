<?php
class productimp_Visualization_Viewmaker {
    public function addMenuItem()
    {
        add_menu_page(
            'NTWCWPPI', 
            'NTWCWPPI', 
            'edit_posts', 
            'ntwcwppi_product_import', 
            array($this, 'createView'), 
            'dashicons-products'
          );
    }

    public function createView()
    {
        echo "<div id='ntwcwppi_app'></div>";
        wp_enqueue_script('productimp_app-vue', plugin_dir_url( __FILE__ ) . 'dist/App.js', [], '1.0', true);
        wp_enqueue_style('productimp_app-styling', plugin_dir_url( __FILE__ ) . 'dist/App.css', [], '1.0', 'all');
        wp_enqueue_style('productimp_font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', [], '1.0', 'all');
    }
}