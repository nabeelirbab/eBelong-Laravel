<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => env('PAYPAL_MODE') != "" ? env('PAYPAL_MODE') : 'live', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'username'    => env('PAYPAL_SANDBOX_API_USERNAME') != "" ? env('PAYPAL_SANDBOX_API_USERNAME') : '',
        'password'    => env('PAYPAL_SANDBOX_API_PASSWORD') != "" ? env('PAYPAL_SANDBOX_API_PASSWORD') : '',
        'secret'      => env('PAYPAL_SANDBOX_API_SECRET') != "" ? env('PAYPAL_SANDBOX_API_SECRET') : '',
        'certificate' => env('PAYPAL_SANDBOX_API_CERTIFICATE', ''),
        'app_id'      => 'APP-80W284485P519543T', // Used for testing Adaptive Payments API in sandbox mode
    ],
    'live' => [
        //'username'    => env('PAYPAL_LIVE_API_USERNAME', ''),
		'username'    => env('PAYPAL_LIVE_API_USERNAME') != "" ? env('PAYPAL_LIVE_API_USERNAME') : '',
        //'password'    => env('PAYPAL_LIVE_API_PASSWORD', ''),
		'password'    => env('PAYPAL_LIVE_API_PASSWORD') != "" ? env('PAYPAL_LIVE_API_PASSWORD') : '',
        //'secret'      => env('PAYPAL_LIVE_API_SECRET', ''),
        'secret'      =>  env('PAYPAL_LIVE_API_SECRET') != "" ? env('PAYPAL_LIVE_API_SECRET') : '',
        'certificate' => env('PAYPAL_LIVE_API_CERTIFICATE', ''),
        'app_id'      => '', // Used for Adaptive Payments API
    ],

    'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => env('PAYMENT_SYMBOL') != "" ? base64_decode(env('PAYMENT_SYMBOL')) : 'USD',
    'billing_type'   => 'MerchantInitiatedBilling',
    'notify_url'     => '', // Change this accordingly for your application.
    'locale'         => '', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => true, // Validate SSL when creating api client.
];
