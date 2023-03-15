<?php
namespace ProductImp\Constants;

/**
 * The centralized error constants
 */
class Errors
{
    public const APP_GENERIC_DATA_PROCESSING_ERROR = 'Something went wrong while processing the data.';
    public const APP_MISSING_REQUIRED_FIELDS = "Missing required fields.";
    public const APP_SYNC_NON_SYNCABLE = "This resource is unsyncable.";
    public const APP_NO_DATASOURCE_FOUND = "No datasource found.";
    public const APP_GENERIC_SUCCESS = "Succesfully stored resource.";
}
