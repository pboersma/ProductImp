<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class productimp_Controllers_DataSourceController implements productimp_Controllers_Interfaces_iController
{
    private $table = 'pipi_datasources';
    private $tableSchema = ['datasource_name', 'datasource_url', 'datasource_credentials'];

    /**
     * @inheritdoc
     */
    public function list(): WP_REST_Response | WP_Error
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;

            return new WP_REST_Response(
                [
                    'data' => $wpdb->get_results("SELECT id, datasource_name, datasource_url FROM $table")
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

    /**
     * @inheritdoc
     */
    public function create(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        $fieldsNotFound = [];

        // Validate that the fields follow the table schema.
        foreach ($this->tableSchema as $field) {
            if (!isset($request[$field])) {
                $fieldsNotFound[] = $field;
            }
        }

        // Early exit if required fields are missing from the request.
        if ($fieldsNotFound) {
            return new WP_Error(
                'missing_fields',
                'Missing Required Fields',
                [
                    'status' => 400,
                    'fields' => $fieldsNotFound
                    ]
                );
        }

        try {
            global $wpdb;
            $table_name = $wpdb->prefix . $this->table;
    
            $wpdb->insert(
                $table_name,
                [
                    'datasource_name'        => $request['datasource_name'],
                    'datasource_url'         => $request['datasource_url'],
                    'datasource_credentials' => json_encode($request['datasource_credentials'])
                ]
            );
    
            return new WP_REST_Response([
                'message' => 'Succesfully stored datasource'
            ], 200);
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

    /**
     * @inheritdoc
     */
    public function read(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;

            $id = $request['id'];
            return new WP_REST_Response(
                [
                    'data' => $wpdb->get_row("SELECT * FROM $table WHERE id = $id")
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

    /**
     * @inheritdoc
     */
    public function update(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        // Validate that the request has an id for the datasource to update.
        if(!$request['id']) {
            return new WP_Error(
                'missing_fields',
                'Missing Required Fields',
                [
                    'status' => 400,
                    'fields' => 'id'
                ]
            );
        }

        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;

            // TODO: Handle fake data.
            $response = $wpdb->update($table, 
                $request['payload'], 
                [
                    'id' => $request['id']
                ]
            );

            return new WP_REST_Response([
                'message' => $response
            ], 
            200);
        } catch(\Exception $e) {
            // Throw exception
        }
    }

    /**
     * @inheritdoc
     */
    public function delete(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        // Validate that the request has an id for the datasource to delete.
        if(!$request['id']) {
            return new WP_Error(
                'missing_fields',
                'Missing Required Fields',
                [
                    'status' => 400,
                    'fields' => 'id'
                ]
            );
        }
        
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;

            $response = $wpdb->delete($table, [
                'id' => $request['id']
            ]);

            return  new WP_REST_Response(
                    [
                        'message' => $response
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

    public function sync(WP_Rest_Request $request): WP_REST_Response | WP_Error
    {
        return WP_REST_Response(
            [
                'data' => "WORK IN PROGRESS"
            ], 
            200
        );

        // if(!$dataSourceId) {
        //     return new WP_Error(
        //         'missing_fields',
        //         'Missing Id',
        //         [
        //             'status' => 400
        //         ]
        //     );
        // }

        // try {
        //     global $wpdb;
        //     $table_name = $wpdb->prefix . $this->table;

        //     $dataSource = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $dataSourceId");

        //     if(!$dataSource) {
        //         return new WP_REST_Response(
        //             [
        //                 'data' => 'No Datasource found, Exiting.'
        //             ], 
        //             200
        //         );
        //     }    
        // } catch(\Exception $e) {
        //     return new WP_Error(
        //         'caught_exception',
        //         $e->getMessage(),
        //         [
        //             'status' => 500
        //         ]
        //     );
        // }
  
        // try {
        //     $client = new Client();

        //     $response = $client->request(
        //         'GET',
        //         $dataSource->datasource_url,
        //         [
        //             // TODO: Conditionally add username & password for auth
        //             'auth' => [
        //                 json_decode($dataSource->datasource_credentials, true)['username'],
        //                 json_decode($dataSource->datasource_credentials, true)['password']
        //             ]
        //         ]
        //     );

        //     $products = json_decode($response->getBody()->getContents(), true);
        // } catch(\Exception $e) {
        //     return new WP_Error(
        //         'caught_exception',
        //         $e->getMessage(),
        //         [
        //             'status' => 500
        //         ]
        //     );
        // }

        // foreach ($products as $product) {
        //     $client = new Client();

        //     $response = $client->request(
        //         'POST',
        //         'https://boersma.dev/wp-json/productimp/v1/products/create',
        //         [
        //             'form_params' => [
        //                "datasource_id" => $dataSourceId,
        //                "product" => $product
        //             ]
        //         ]
        //     );
        // }

        // return new WP_REST_Response(
        //     [
        //         'data' => $response->getBody()->getContents()
        //     ], 
        //     200
        // );

    }
}
