<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class productimp_Controllers_DataSourceController implements productimp_Controllers_Interfaces_iController
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

    public function sync(WP_REST_Request $request)
    {
        try {
            if(!$request['id']) {
                return new WP_REST_Response(
                    [
                        'message' => "No Datasource ID sent, Skipping."
                    ], 
                    200
                );
            }

            $id = $request['id'];


            global $wpdb;
            $table = $wpdb->prefix . $this->table;

            $datasource = $wpdb->get_row("SELECT id, datasource_name, datasource_url, datasource_credentials FROM $table WHERE id = $id");

        
            if(!$datasource) {
                return new WP_REST_Response(
                    [
                        'message' => "No Datasource found with supplied id"
                    ], 
                    200
                );
            }

            // Set Guzzle Client.
            $client = new Client([
                'base_uri' => "https://$_SERVER[HTTP_HOST]"
            ]);

            $datasource_credentials = json_decode($datasource->datasource_credentials, true);

            $response = $this->sendRequest(
                $client, 
                $datasource->datasource_url, 
                $datasource_credentials['username'], 
                $datasource_credentials['password']
            );

            $data = $this->parseResponse($response);

            // Insert all products one-by-one.
            foreach ($data as $product) {
                $response = $client->request(
                    'POST',
                    'wp-json/productimp/v1/products/create',
                    [
                        'form_params' => [
                            "datasource_id" => $datasource->id,
                            "product" => $product
                        ]
                    ]
                );
            }

            return new WP_REST_Response(
                [
                    'message' => $response->getBody()->getContents()
                ], 
                200
            );
        } catch (\Exception $e) {
            // Log the error
            error_log('Error while fetching data: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a GET request to the specified endpoint with optional basic authentication.
     *
     * @param string $endpoint The endpoint to send the request to
     * @param string $username The username to use for basic authentication (optional)
     * @param string $password The password to use for basic authentication (optional)
     *
     * @return \GuzzleHttp\Psr7\Response The response from the request
     */
    private function sendRequest(Client $client, $endpoint, $username = null, $password = null)
    {
        $options = ['stream' => true];
        
        if ($username !== null && $password !== null) {
            $options['auth'] = [$username, $password];
        }
    
        $response = $client->request('GET', $endpoint, $options);
    
        return $response;
    }

    /**
     * Parse the response from a REST API into an associative array.
     *
     * @param Response $response The response from the REST API.
     * 
     * @return array The JSON data from the response, as an associative array.
     */
    private function parseResponseJson($response)
    {
        $body = $response->getBody();
        $jsonData = '';
    
        while (!$body->eof()) {
            // Read the chunk of data
            $chunk = $body->read(1024);
            // Concatenate the chunk to the $jsonData string
            $jsonData .= $chunk;
        }
    
        // Return the JSON data as an associative array
        return json_decode($jsonData, true);
    }

    private function parseResponseCSV($response)
    {
        $csvString = (string) $response->getBody();

        $csvData = str_getcsv($csvString, "\n"); // Split CSV into lines
        $header = str_getcsv(array_shift($csvData)); // Get header row
    
        // Convert header to snake_case and remove problematic characters
        $header = array_map(function ($field) {
            $field = strtolower(trim($field));
            $field = preg_replace('/[^a-z0-9_]/', '', $field);
            return str_replace(' ', '_', $field);
        }, $header);
    
        $data = [];

        foreach ($csvData as $row) {
            $rowData = str_getcsv($row);
            // If row has fewer fields than header, pad with empty strings
            $rowData = array_pad($rowData, count($header), '');
            $rowArray = array_combine($header, $rowData); // Combine header with row data
            $rowArray = array_filter($rowArray, function($value) {
                return !empty($value);
            }); // Remove keys where value is empty
            $data[] = $rowArray;
        }

        return $data;
    }
    
    private function parseResponse($response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        
        if (strpos($contentType, 'application/json') !== false) {
            return $this->parseResponseJson($response);
        } elseif (strpos($contentType, 'application/octet-stream') !== false) {
            // TURN OFF FOR NOW.
            // return false;
            return $this->parseResponseCSV($response);
        } else {
            return false;
        }
    }
}
