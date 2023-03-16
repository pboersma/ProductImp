<?php
namespace ProductImp\Controllers;

use ProductImp\Constants\Http;
use ProductImp\Constants\Errors;
use ProductImp\Helpers\Validator;

class ProductsMappingController {
    private $table = 'pi_products_mapping';
    private $tableSchema = ['product_id', 'map'];

    public function create(\WP_REST_Request $request): \WP_REST_Response
    {
        $hasRequiredFields = Validator::hasRequiredFields(
            $this->tableSchema, 
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
        $table_name = $wpdb->prefix . $this->table;

        $response =  $wpdb->replace(
            'wp_pipi_products_map',
            [
                'product_id' => $request['product_id'],
                'map' => json_encode($request['map']),
            ]
        );
        
        // If the query went wrong for some reason, Return.
        if(!$response) {
            return new \WP_REST_Response(
                [
                    "message" => Errors::APP_GENERIC_DATA_PROCESSING_ERROR
                ],
                Http::HTTP_BAD_REQUEST
            );
        }

        // Everything was successfull.
        return new \WP_REST_Response(
            [
                "message" => Errors::APP_GENERIC_SUCCESS
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
                $wpdb->get_results("SELECT id, product_id, map FROM $table")
            ],
            Http::HTTP_OK
        );
    }

    public function readSingle(\WP_REST_Request $request): \WP_REST_Response
    {
        $hasRequiredFields = Validator::hasRequiredFields(
            ['id'], 
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

        $response = $wpdb->get_row($wpdb->prepare("SELECT id, product_id, map FROM $table WHERE id = %d", $request['id']));

        return  new \WP_REST_Response(
            [
                'message' => $response
            ], 
            Http::HTTP_OK
        );

    }

    public function delete(\WP_REST_Request $request): \WP_REST_Response
    {
        $hasRequiredFields = Validator::hasRequiredFields(
            ['id'], 
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

        $response = $wpdb->delete($table, [
            'id' => $request['id']
        ]);

        return  new \WP_REST_Response(
            [
                'message' => $response
            ], 
            Http::HTTP_OK
        );
    }
}