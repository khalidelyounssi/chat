<?php

return [
    'whatsapp' => [
        'number' => env('WHATSAPP_NUMBER', '212XXXXXXXXX'),
        'default_text' => env('WHATSAPP_DEFAULT_TEXT', 'Bonjour je suis interesse'),
    ],

    'statuses' => [
        'available' => 'Disponible',
        'reserved' => 'Reserve',
        'sold' => 'Vendu',
    ],

    'genders' => [
        'male' => 'Male',
        'female' => 'Femelle',
    ],
];
