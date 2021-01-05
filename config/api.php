<?php

return [

    'name' => env('API_NAME', 'api'),

    'version' => env('API_VERSION', 'v1'),

    'messages' => [
        'error' => env('API_MESSAGES_ERROR', 'Ocorreu um problema interno'),
        'message' => env('API_MESSAGES_MESSAGE', 'Verifique os campos da sua requisição')
    ]
];
