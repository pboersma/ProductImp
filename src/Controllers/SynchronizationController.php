<?php
namespace ProductImp\Controllers;

use ProductImp\Helpers\Validator;
use ProductImp\Helpers\Request;
use ProductImp\Constants\Http;
use ProductImp\Constants\Errors;
use GuzzleHttp\Client;


class SynchronizationController
{
    private $syncables = ['DataSource'];

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

        // Set Guzzle Client.
        $client = new Client();
        $datasource_credentials = json_decode($datasource->datasource_credentials, true);

        $requestHelper = new Request;

        $response = $requestHelper->sendRequest(
            $client, 
            $datasource->datasource_url, 
            $datasource_credentials['username'], 
            $datasource_credentials['password']
        );

        $data = $requestHelper->parseResponse($response);

        return $data;
    }
}