<?php
namespace ProductImp\Helpers;

use GuzzleHttp\Client;

class Request
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
    public function sendRequest($endpoint, $username = null, $password = null)
    {
        // Set Guzzle Client.
        $client = new Client();
        
        $options = ['stream' => true];
        
        if ($username !== null && $password !== null) {
            $options['auth'] = [$username, $password];
        }
    
        $response = $client->request('GET', $endpoint, $options);
    
        return $response;
    }

    public function parseResponse($response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        
        if (strpos($contentType, 'application/json') !== false) {
            return $this->parseResponseJson($response);
        } elseif (strpos($contentType, 'application/octet-stream') !== false) {
            // TURN OFF FOR NOW.
            return false;
            return $this->parseResponseCSV($response);
        } else {
            return false;
        }
    }

    /**
     * Parse the response from a REST API into an associative array.
     *
     * @param Response $response The response from the REST API.
     * 
     * @return array The JSON data from the response, as an associative array.
     */
    public function parseResponseJson($response)
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
}