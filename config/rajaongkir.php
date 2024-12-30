<?php

return [
    'api_key' => env('RAJAONGKIR_API_KEY', ''),
    'origin_city_id' => env('RAJAONGKIR_ORIGIN_CITY_ID'),
    'endpoints' => [
        'province' => 'https://api.rajaongkir.com/starter/province',
        'city' => 'https://api.rajaongkir.com/starter/city',
    ],
];