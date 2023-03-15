<?php
namespace App\Controllers;

// use App\Controllers\Interfaces\productimp_Controllers_Interfaces_iController;
use App\Constants\Errors;

class productimp_Controllers_DataSourceController
{
    private $table = 'pi_datasources';
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
                    'data' => $wpdb->get_row("SELECT id, datasource_name, datasource_url, created_on FROM $table WHERE id = $id")
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

    public function sync(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        $body = $request->get_body();

        if(!$body) {
            return  new WP_REST_Response(
                [
                    'message' => Errors::APP_GENERIC_DATA_PROCESSING_ERROR
                ], 
                400
            );
        }
        
        var_dump($body);
        die;

        // try {
        //     if(!$request['id']) {
        //         return new WP_REST_Response(
        //             [
        //                 'message' => "No Datasource ID sent, Skipping."
        //             ], 
        //             200
        //         );
        //     }

        //     $id = $request['id'];


        //     global $wpdb;
        //     $table = $wpdb->prefix . $this->table;

        //     $datasource = $wpdb->get_row("SELECT id, datasource_name, datasource_url, datasource_credentials FROM $table WHERE id = $id");

        
        //     if(!$datasource) {
        //         return new WP_REST_Response(
        //             [
        //                 'message' => "No Datasource found with supplied id"
        //             ], 
        //             200
        //         );
        //     }

        //     // Set Guzzle Client.
        //     $client = new Client([
        //         'base_uri' => "https://$_SERVER[HTTP_HOST]"
        //     ]);

        //     $datasource_credentials = json_decode($datasource->datasource_credentials, true);

        //     $response = $this->sendRequest(
        //         $client, 
        //         $datasource->datasource_url, 
        //         $datasource_credentials['username'], 
        //         $datasource_credentials['password']
        //     );

        //     $data = $this->parseResponse($response);

        //     // Insert all products one-by-one.
        //     foreach ($data as $product) {
        //         $response = $client->request(
        //             'POST',
        //             'wp-json/productimp/v1/products/create',
        //             [
        //                 'form_params' => [
        //                     "datasource_id" => $datasource->id,
        //                     "ean" => $product['ean'],
        //                     "product" => $product
        //                 ]
        //             ]
        //         );
        //     }

        //     return new WP_REST_Response(
        //         [
        //             'message' => $response->getBody()->getContents()
        //         ], 
        //         200
        //     );
        // } catch (\Exception $e) {
        //     // Log the error
        //     error_log('Error while fetching data: ' . $e->getMessage());
        //     return false;
        // }
    }
}
