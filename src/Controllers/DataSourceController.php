<?php
namespace ProductImp\Controllers;

use ProductImp\Constants\Http;
use ProductImp\Constants\Errors;
use ProductImp\Helpers\Validator;

class DataSourceController {
    private $table = 'pi_datasources';
    private $tableSchema = ['datasource_name', 'datasource_url', 'datasource_credentials'];

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

        $response = $wpdb->insert(
                $table_name,
                [
                    'datasource_name'        => $request['datasource_name'],
                    'datasource_url'         => $request['datasource_url'],
                    'datasource_credentials' => json_encode($request['datasource_credentials'])
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
                $wpdb->get_results("SELECT id, datasource_name, datasource_url FROM $table")
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

        $response = $wpdb->get_row($wpdb->prepare("SELECT id, datasource_name, datasource_url FROM $table WHERE id = %d", $request['id']));

        return  new \WP_REST_Response(
            [
                'message' => $response
            ], 
            200
        );

    }

    public function update(\WP_REST_Request $request): \WP_REST_Response
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

        $response = $wpdb->update($table, 
            json_decode($request->get_body(), true),
            [
                'id' => $request['id']
            ]
        );

        return new \WP_REST_Response(
            [
                'message' => $request['id']
            ], 
            HTTP::HTTP_OK
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
            200
        );
    }
}