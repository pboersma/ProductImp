<?php
namespace ProductImp\Controllers;

use ProductImp\Constants\Http;
use ProductImp\Constants\Errors;
use ProductImp\Helpers\Validator;
use Automattic\WooCommerce\Client;

class WooCommerceController {
    private $table = 'pi_products_woocommerce';

    public function create(\WP_REST_Request $request): \WP_REST_Response
    {
        $hasRequiredFields = Validator::hasRequiredFields(
            ['product_id'], 
            $request
        );

        // If the Validator returned required fields, Early return.
        if(!empty($hasRequiredFields)) {
            return new \WP_REST_Response(
                [
                    "message" => Errors::APP_MISSING_REQUIRED_FIELDS,
                    "fields" => $hasRequiredFields
                ],
                Http::HTTP_BAD_REQUEST
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
            get_site_url() . '/',
            $wooCommerceAuthorized['consumer_key'],
            $wooCommerceAuthorized['consumer_secret'],
            [
              'timeout' => 240, // 2 Minute Timeout
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

        $productMapping = new \WP_REST_Request('GET', '/productimp/v1/mapping/' . $request['product_id']);
        $response = rest_do_request($productMapping);
        $productMapping = $response->get_data()['message']->map;

        if(!$productMapping) {
            return new \WP_REST_Response(
                [
                    "message" => Errors::APP_GENERIC_DATA_PROCESSING_ERROR
                ],
                Http::HTTP_BAD_REQUEST
            );
        }

        $product = new \WP_REST_Request('GET', '/productimp/v1/product/' . $request['product_id']);
        $response = rest_do_request($product);
        $product = $response->get_data()['message']->product;

        $data = $this->interpretMapping(
            json_decode($productMapping, true), 
            json_decode($product, true)
        );

        var_dump($data);
        die;

        global $wpdb;

        $table = $wpdb->prefix . $this->table;
        
        // Create a new product in woocommerce, If it already exists, update it.
        try {
            $wooCommerceResponse = $woocommerce->post('products', $data);      

            $wpdb->insert(
                $table,
                [
                    'product_id' => $request['product_id'],
                    'woocommerce_product_id' => $wooCommerceResponse->id,
                ]
            );
        } catch(\Exception $e) {
            $response = $wpdb->get_row($wpdb->prepare("SELECT id, product_id, woocommerce_product_id FROM $table WHERE product_id = %d", $request['product_id']));
            $wooCommerceResponse = $woocommerce->put('products/' . $response->woocommerce_product_id, $data);
        }

        return new \WP_REST_Response(
            [
                $data
            ], 
            200
        );
    }

    public function readSingle(\WP_REST_Request $request): \WP_REST_Response
    {
        $hasRequiredFields = Validator::hasRequiredFields(
            ['product_id'], 
            $request
        );

        // If the Validator returned required fields, Early return.
        if(!empty($hasRequiredFields)) {
            return new \WP_REST_Response(
                [
                    "message" => Errors::APP_MISSING_REQUIRED_FIELDS,
                    "fields" => $hasRequiredFields
                ],
                Http::HTTP_BAD_REQUEST
            );
        }

        global $wpdb;
        $table = $wpdb->prefix . $this->table;

        $response = $wpdb->get_row($wpdb->prepare("SELECT id, product_id, woocommerce_product_id FROM $table WHERE product_id = %d", $request['product_id']));

        return  new \WP_REST_Response(
            [
                'message' => $response
            ], 
            Http::HTTP_OK
        );

    }

    public function read(): \WP_REST_Response
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table;

        return new \WP_REST_Response(
            [
                $wpdb->get_results("SELECT id, product_id, woocommerce_product_id FROM $table")
            ],
            Http::HTTP_OK
        );
    }

    private function interpretMapping($mapping, $product)
    {
        $data = [];

        foreach($mapping as $key => &$value) {
            // Concat
            if((bool) preg_match('/\./', $value['product_field_id'])) {
              
                $selectors = explode(".", $value['product_field_id']);

                if($value['woocommerce_field_id'] === 'images') {
                    foreach($product[$selectors[0]][$selectors[1]] as $key => $image) {
                        $data['images'][$key]['src'] = $image;
                    }

                    // Unset the fields so that they do not get mapped twice.
                    unset($value['product_field_id']);
                    unset($value['woocommerce_field_id']);
                }
            }
     
            // Hardcode
            if(preg_match('/\{\w*\}/', $value['product_field_id'])) {
                $data[$value['woocommerce_field_id']] = str_replace(['{', '}'], '', $value['product_field_id']);
            }
     
            $data[$value['woocommerce_field_id']] = (string) $product[$value['product_field_id']] ?? null;
        }

        return $data;
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

}