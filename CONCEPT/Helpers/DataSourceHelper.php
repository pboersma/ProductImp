<?php

class productimp_Helpers_DataSourceHelper
{
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
