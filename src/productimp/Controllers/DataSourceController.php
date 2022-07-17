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

        // Early exit if required fields are missing from the request.
        if($fieldsNotFound) {
            return new WP_Error( 
                'missing_fields', 
                'Missing Required Fields', 
                array( 'status' => 400 ) 
            );
            // return [
            //     'status' => 400, // Bad Request HTTP Status code
            //     'message' => 'Missing required fields',
            //     'fields' => $fieldsNotFound
            // ];
        }
    }
}