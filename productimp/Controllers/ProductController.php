<?php

class productimp_Controllers_ProductController implements productimp_Controllers_Interfaces_iController
{
    private $table = 'pipi_products';
    private $tableSchema = ['datasource_id', 'product'];

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
                    'datasource_id'          => $request['datasource_id'],
                    'product'                => json_encode($request['product']),
                ]
            );
    
            return new WP_REST_Response([
                'message' => 'Succesfully stored product'
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
}
