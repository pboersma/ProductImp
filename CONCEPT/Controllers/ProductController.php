<?php

class productimp_Controllers_ProductController implements productimp_Controllers_Interfaces_iController
{
    private $table = 'pi_products';
    private $tableSchema = ['datasource_id', 'ean', 'product'];

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
                    'data' => $wpdb->get_results("SELECT * FROM $table LIMIT 10")
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

            $sql = "INSERT INTO {$table_name} (datasource_id,ean,product) VALUES (%d,%s,%s) ON DUPLICATE KEY UPDATE product = %s";
            $sql = $wpdb->prepare(
                $sql,
                $request['datasource_id'],
                $request['ean'],
                wp_json_encode($request['product']),
                wp_json_encode($request['product'])
            );
    
            return new WP_REST_Response([
                'message' => $wpdb->query($sql)
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

            $id = $request->get_body()['id'];

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

    /**
     * @inheritdoc
     */
    public function map(WP_REST_Request $request): WP_REST_Response | WP_Error
    {
        // Validate that the request has an id for the datasource to update.
        if(!$request['product_id']) {
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

            $wpdb->replace(
                'wp_pi_products_map',
                [
                    'product_id'             => $request['product_id'],
                    'map'                    => json_encode($request['map']),
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
    public function getMap(WP_REST_Request $request)
    {
        try {
            global $wpdb;
            $table = $wpdb->prefix . $this->table;

            $id = $request->get_body()['product_id'];

            return new WP_REST_Response(
                [
                    $wpdb->get_row("SELECT * FROM wp_pi_products_map WHERE product_id = '$id';")
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
    public function getMappings(): WP_REST_Response | WP_Error
    {
        try {
            global $wpdb;
            $table = 'wp_pi_products_map';

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
}
