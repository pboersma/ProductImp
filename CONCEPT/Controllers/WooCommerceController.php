<?php
use Automattic\WooCommerce\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;


class productimp_Controllers_WooCommerceController
{
    public function createProduct(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        if(!$request['product_id']) {
            return new WP_Error(
                'missing_product',
                'Make sure to send in a product id for syncing to WooCommerce',
                [
                    'status' => 400
                ]
            );
        }

        $wooCommerceAuthorized = json_decode(get_option('productimp_rest'), true);

        // If the client has not authorized with the Woocommerce API, Return.
        if(!$wooCommerceAuthorized) {
            return new WP_Error(
                'unauthorized',
                'No authorization found for WooCommerce, Please Authorize first.',
                [
                    'status' => 400
                ]
            );
        }

        // Create Woocommerce Client for the rest api calls.
        $woocommerce = new Client(
            'https://boersma.dev/',
            $wooCommerceAuthorized['consumer_key'],
            $wooCommerceAuthorized['consumer_secret'],
            [
              'timeout' => 120, // 2 Minute Timeout
              'version' => 'wc/v3',
            ]
        );

        // Make sure the client actually is instantiated
        if(!$woocommerce) {
            return new WP_Error(
                'unauthorized',
                'No authorization found for WooCommerce, Please Authorize first.',
                [
                    'status' => 400
                ]
            );
        }

        $productMapping = new WP_REST_Request('POST', '/productimp/v1/products/map/get');
        $productMapping->set_body(['product_id' => $request['product_id']]);
        $response = rest_do_request($productMapping);
        $productMapping = $response->get_data()[0];

        $product = new WP_REST_Request('GET', '/productimp/v1/products/read');
        $product->set_body(['id' => $request['product_id']]);
        $response = rest_do_request($product);
        $product = $response->get_data()['data'];

        $data = $this->interpretMapping(
            json_decode($productMapping->map, true), 
            json_decode($product->product, true)
        );

        $images = $data['images'];

        unset($data['sku']);
        
        $wooCommerceResponse = $woocommerce->post('products', $data);

        // Insert mapped product & woocommerce product id for keeping track of product.
        global $wpdb;

        $wpdb->insert(
            'wp_pi_products_woocommerce',
            [
                'product_id' => $request['product_id'],
                'woocommerce_product_id' => $wooCommerceResponse->id,
            ]
        );

        return new WP_REST_Response(
            [
                $wooCommerceResponse
            ], 
            200
        );
    }

    public function getProducts()
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . 'pi_products_woocommerce';

            return new WP_REST_Response(
                [
                    'data' => $wpdb->get_results("SELECT * FROM $table")
                ], 
                200
            );
        } catch(\Exception $e) {
            return new WP_Error(
                'caught_exception',
                $e->getMessage(),
                [
                    'status' => 500
                ]
            );
        }
    }

    public function findProduct(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        try {
            global $wpdb;

            $id = $request['id'];
            return new WP_REST_Response(
                [
                    'data' => $wpdb->get_row("SELECT * FROM wp_pi_products_woocommerce WHERE product_id = $id")
                ], 
                200
            );
        } catch(\Exception $e) {
            return new WP_Error(
                'caught_exception',
                $e->getMessage(),
                [
                    'status' => 500
                ]
                );
        }
    }

    private function checkExists($url)
    {
        $image_type_check = @exif_imagetype($url);
        if (strpos($http_response_header[0], "403") || strpos($http_response_header[0], "404") || strpos($http_response_header[0], "302") || strpos($http_response_header[0], "301")) {
            return false;
        } else {
            return true;
        }
    }

    private function interpretMapping($mapping, $product)
    {
        $data = [];

        foreach($mapping as $key => &$value) {
            $data[$value['woocommerce_field_id']] = $product[$value['product_field_id']] ?? null;

            // Concat
            if((bool) preg_match('/\./', $value['product_field_id'])) {
                $selectors = explode(".", $value['product_field_id']);

                if($value['woocommerce_field_id'] === 'images') {
                    foreach($product[$selectors[0]][$selectors[1]] as $key => $image) {
                        if($this->checkExists($image)) {
                            $data['images'][$key]['src'] = $image;
                        }
                    }
                }
            }
     
            // Hardcode
            if(preg_match('/\{\w*\}/', $value['product_field_id'])) {
                $data[$value['woocommerce_field_id']] = str_replace(['{', '}'], '', $value['product_field_id']);
            }
        }

        return $data;
    }
}
