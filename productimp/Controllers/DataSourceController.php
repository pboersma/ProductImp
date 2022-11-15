<?php

class productimp_Controllers_DataSourceController implements productimp_Controllers_Interfaces_iController
{
    private $table = 'pipi_datasources';

    public function list(WP_REST_Request $request): Array
    {
        global $wpdb;

        return [
            // 'total' => $total,
            'data' => $wpdb->get_results("SELECT * FROM wp_pipi_datasources")
        ];
    }

    /**
     * Store Datasource
     */
    public function store(WP_REST_Request $request)
    {
        $requiredFields = ['datasource_name', 'datasource_url', 'datasource_credentials'];

        foreach ($requiredFields as $field) {
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

        $table_name = $wpdb->prefix . $this->table;

        $wpdb->insert(
            $table_name,
            [
                'datasource_name'        => $request['datasource_name'],
                'datasource_url'         => $request['datasource_url'],
                'datasource_credentials' => json_encode($request['datasource_credentials'])
            ]
        );

        return [
            'message' => 'Succesfully stored datasource'
        ];
    }

    public function sync(WP_REST_Request $request)
    {
        $dataSourceId = $request['id'];

        if(!$dataSourceId) {
            return new WP_Error(
                'missing_fields',
                'Missing Id',
                [
                    'status' => 400
                ]
            );
        }

        global $wpdb;
        $table_name = $wpdb->prefix . $this->table;


        // Get credentials
        return [
            'data' => $wpdb->get_results(`SELECT * FROM ${table_name} WHERE id = ${dataSourceId}`)
        ];

    }
}
