<?php

class productimp_Controllers_DataSourceController implements productimp_Controllers_Interfaces_iController
{
    public function list(): array
    {
        return [];
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

        global $wpdb;

        $table_name = $wpdb->prefix . 'pipi_datasources';

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
        ]
    }
}
