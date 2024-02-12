<?php
/** set your paypal credential **/

$config['client_id'] = 'AaRbLLYG7qrGqfb2aiZxO4-EjBkfC2Vo4WsEgyW0-vR6aBeUwNfav-iVE-QozjZjTHRNCzRzeKJDOvAY';
$config['secret'] = 'EHjB3JRkndq3dMri3e0osyejszZyiyD1QpAIRwgBmRyXjIdqyB0Y9AH5eM-vnxo4K1oqOLzGLneDR7mL';

/**
 * SDK configuration
 */
/**
 * Available option 'sandbox' or 'live'
 */
$config['settings'] = array(

    'mode' => 'sandbox',
    /**
     * Specify the max request time in seconds
     */
    'http.ConnectionTimeOut' => 1000,
    /**
     * Whether want to log to a file
     */
    'log.LogEnabled' => true,
    /**
     * Specify the file that want to write on
     */
    'log.FileName' => 'application/logs/paypal.log',
    /**
     * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
     *
     * Logging is most verbose in the 'FINE' level and decreases as you
     * proceed towards ERROR
     */
    'log.LogLevel' => 'FINE'
);