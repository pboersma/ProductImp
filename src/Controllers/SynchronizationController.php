<?php
namespace ProductImp\Controllers;

use ProductImp\Helpers\Validator;
use ProductImp\Helpers\Request;
use ProductImp\Constants\Http;
use ProductImp\Constants\Errors;

class SynchronizationController
{
    private $syncables = ['DataSource', 'WooCommerce'];

    public function synchronize(\WP_REST_Request $request): \WP_REST_Response
    {
        $hasRequiredFields = Validator::hasRequiredFields(
            ['resource', 'id'], 
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

        // Check if the Resource is even syncable.
        if(!in_array($request['resource'], $this->syncables)) {
            return new \WP_REST_Response(
                [
                    "message" => Errors::APP_SYNC_NON_SYNCABLE
                ],
                Http::HTTP_BAD_REQUEST
            );
        }

        // Invoke the resource sync method.
        return new \WP_REST_Response(
            [
                "message" => $this->{$request['resource']}($request['id'])
            ],
            Http::HTTP_OK
        );
    }

    private function DataSource($id)
    {
        global $wpdb;
        $table = $wpdb->prefix . "pi_datasources";

        $datasource = $wpdb->get_row("SELECT id, datasource_name, datasource_url, datasource_credentials FROM $table WHERE id = $id");

        if(!$datasource) {
            return Errors::APP_NO_DATASOURCE_FOUND;
        }
    
        $datasource_credentials = json_decode($datasource->datasource_credentials, true);

        $requestHelper = new Request;
        $response = $requestHelper->sendRequest(
            $datasource->datasource_url, 
            $datasource_credentials['username'], 
            $datasource_credentials['password']
        );

        $data = $requestHelper->parseResponse($response);

        $productRequest = new \WP_REST_Request('POST', '/productimp/v1/product');
        $productRequest->set_header('Content-Type', 'application/json');
        
        // Insert all products one-by-one.
        foreach ($data as $product) {
            $productRequest->set_body(
                json_encode(
                    [
                        'datasource_id' => $datasource->id,
                        'ean'           => $product['ean'],
                        'product'       => $product
                    ]
                )
            );

            rest_do_request($productRequest);
        }

        $table_name = $wpdb->prefix . 'pi_products_woocommerce';

        $rows = $wpdb->get_results( "SELECT * FROM $table_name");

        if($rows) {
            foreach ($rows as $product) {
                $woocommerceRequest = new \WP_REST_Request('POST', '/productimp/v1/woocommerce/' . $product->product_id);
                rest_do_request($woocommerceRequest); 
            }
        }
            
        return $data;
    }
}