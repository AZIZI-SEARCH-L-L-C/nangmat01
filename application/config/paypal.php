<?php
return array(
    // set your paypal credential
    'enabled' => env('PAYPAL_ENABLED', false),
    'client_id' => env('PAYPAL_CLIENT_ID', ''),
    'secret'    => env('PAYPAL_CLIENT_SECRET', ''),
 
    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => env('PAYPAL_MODE', 'sandbox'),
 
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,
 
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
 
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
 
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'INFO'
    ),
);