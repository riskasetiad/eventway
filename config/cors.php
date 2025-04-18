<?php

return [

    'paths'                    => ['api/*', 'uploads/*', '*'],

    'allowed_methods'          => ['*'],

    'allowed_origins'          => ['*'], // untuk testing, bisa batasi ke IP frontend

    'allowed_origins_patterns' => [],

    'allowed_headers'          => ['*'],

    'exposed_headers'          => [],

    'max_age'                  => 0,

    'supports_credentials'     => false,

];
