<?php
class productimp_Visualization_Viewmaker {
    public function addMenuItem()
    {
        add_menu_page(
            'productimp', 
            'productimp', 
            'edit_posts', 
            'productimp_product_import', 
            array($this, 'createView'), 
            'dashicons-products'
          );
    }

    public function createView()
    {
        echo "<div id='app'></div>";
        wp_enqueue_script('productimp_app-chunk', plugin_dir_url( __FILE__ ) . 'dist/js/chunk-vendors.js', [], '1.0', true);
        wp_enqueue_script('productimp_app-vue', plugin_dir_url( __FILE__ ) . 'dist/js/app.js', [], '1.0', true);
        wp_enqueue_style('productimp_app-styling', plugin_dir_url( __FILE__ ) . 'dist/css/app.css', [], '1.0', 'all');
        wp_enqueue_style('productimp_font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', [], '1.0', 'all');
        
        // Nonce Implementation
        wp_localize_script('productimp_app-vue', 'ProductImp', [
            'root' => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);
    }
}