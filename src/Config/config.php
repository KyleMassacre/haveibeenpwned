<?php

return [
    /*
     * Required
     * If you don't have a user agent set up then Have I been pwned will reject your request
     */
    'user_agent' => env('USER_AGENT', env('APP_NAME')." ';-- Password checker"),

    /*
     * If the complete breach data is not required and you'd like to reduce the response body size,
     * you can request that the breach entity be truncated so that only the name attribute is returned
     * (reduces response body size by approximately 98%):
     *
     * Returns only the name of the breach.
     */
    'truncate_results' => true,

    /*
     * Note: the public API will not return accounts from any breaches flagged as sensitive or retired.
     * By default, the API also won't return breaches flagged as unverified, however these can be included
     * by using the following parameter:
     *
     * Returns breaches that have been flagged as "unverified".
     * By default, only verified breaches are returned web performing a search.
     */
    'include_unverified' => true,
];
