<?php
interface productimp_Controllers_Interfaces_iController
{
    /**
     * List all resources
     * 
     * @return WP_REST_Response List of resources
     */
    public function list(): WP_REST_Response | WP_Error;

    /**
     * Create a new resource
     * 
     * @param WP_REST_Request $request Wordpress request Object (payload)
     * 
     * @return WP_REST_Response List of resources
     */
    public function create(WP_REST_Request $request): WP_REST_Response | WP_Error;

    /**
     * List only one resource depending on id
     * 
     * @param WP_REST_Request $request Wordpress request Object (id)
     * 
     * @return WP_REST_Response List of resources
     */
    public function read(WP_REST_Request $request): WP_REST_Response | WP_Error;

    /**
     * Update a resource depending on the given id
     * 
     * @param WP_REST_Request $request Wordpress request Object (id + payload)
     * 
     * @return WP_REST_Response List of resources.
     */
    public function update(WP_REST_Request $request): WP_REST_Response | WP_Error;

    /**
     * Delete a resource depending on an id.
     * 
     * @param WP_REST_Request $request Wordpress request Object (id)
     * 
     * @return WP_REST_Response List of resources.
     */
    public function delete(WP_REST_Request $request): WP_REST_Response | WP_Error;
}