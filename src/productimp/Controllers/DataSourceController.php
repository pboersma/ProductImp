<?php

class productimp_Controllers_DataSourceController implements productimp_Controllers_Interfaces_iController
{
    public function list(WP_REST_Request $request): Array
    {
        global $wpdb;
        // TODO: Can be a lot cleaner.
        if (!isset($request['limit'])) {
            $limit = 10;
        } else {
            $limit = $request['limit'];
        }

        if (isset($request['page'])) {
            $pageno = $request['page'];
        } else {
            $pageno = 1;
        }

        $offset = ($pageno - 1) * $limit;
        $totalDatasources = $wpdb->get_var("SELECT COUNT(*) FROM wp_productimp_products");
        $total = ceil($totalDatasources / $limit);

        return [
            'total' => $total,
            'data' => $wpdb->get_results("SELECT * FROM wp_pipi_datasources LIMIT $offset, $limit")
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
        ];
    }
}
