<?php
namespace ProductImp\Helpers;

class Validator
{
    public static function hasRequiredFields(Array $schema, \WP_REST_Request $request)
    {
        $fieldsNotFound = [];

        // Validate that the fields follow the table schema.
        foreach ($schema as $field) {
            if (!isset($request[$field])) {
                $fieldsNotFound[] = $field;
            }
        }

        return $fieldsNotFound;
    }
}
