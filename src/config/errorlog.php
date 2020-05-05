<?php

return [
        'MAIL_FROM_ADDRESS' => env("MAIL_FROM_ADDRESS","from@example.com"),
        'MAIL_FROM_NAME' => env('MAIL_FROM_NAME','Example'),
        'MAIL_TO_ADDRESS' => env('MAIL_TO_ADDRESS','to@example.com'),
        'MAIL_CC_ADDRESS' => env('MAIL_CC_ADDRESS','cc@example.com'),
        'ROUTE_PREFIX' => env('ROUTE_PREFIX', '/'),
        'MIDDLEWARE' => env('MIDDLEWARE', 'web')
];