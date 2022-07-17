<?php

class productimp_Controllers_DataSourceController implements productimp_Controllers_Interfaces_iController  {
    public function list(): Array
    {
        return [];
    }

    /**
     * Store Datasource
     */
    public function store(WP_REST_Request $request)
    {
        $requiredFields = ['datasource_name', 'datasource_url'];

        foreach($requiredFields as $field) {
            if(!isset($request[$field])) {
                $fieldsNotFound[] = $field;
            }
        }

        if($fieldsNotFound) {
            return [
                // Bad Request HTTP
                'status' => 400,
                'message' => 'Missing required fields',
                'fields' => $fieldsNotFound
            ];
        }
    }
}