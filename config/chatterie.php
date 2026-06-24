<?php

$adminEmails = array_values(array_filter(array_map(
    static fn (string $email): string => trim($email),
    explode(',', (string) env('ADMIN_EMAILS', env('ADMIN_EMAIL', 'admin@soleils-orient.test')))
)));

return [
    'admin' => [
        'emails' => $adminEmails,
    ],

    'site' => [
        'name' => env('CHATTERIE_NAME', env('APP_NAME', "Chatterie des Soleils d'Orient")),
        'owner_name' => env('CHATTERIE_OWNER_NAME', 'Mme KAYADELEN Sinem'),
        'tagline' => env('CHATTERIE_TAGLINE', "Chatterie d'Abyssins"),
        'city' => env('CHATTERIE_CITY', 'Saint-Ave'),
        'country' => env('CHATTERIE_COUNTRY', 'France'),
        'address' => env('CHATTERIE_ADDRESS', '16B Rue Joseph le Brix, 56890 Saint-Ave'),
        'phone' => env('CHATTERIE_PHONE', '06.51.09.03.36'),
        'email' => env('CHATTERIE_EMAIL', env('MAIL_FROM_ADDRESS', 'chatteriedessoleilsdorient@outlook.fr')),
        'hours' => env('CHATTERIE_HOURS', 'Du lundi au samedi, de 10h00 a 18h00'),
        'legal_name' => env('CHATTERIE_LEGAL_NAME', "Chatterie des Soleils d'Orient"),
        'legal_status' => env('CHATTERIE_LEGAL_STATUS', "Elevage de chats abyssins"),
        'meta_description' => env(
            'CHATTERIE_META_DESCRIPTION',
            "Chatterie des Soleils d'Orient a Saint-Ave : elevage de chats abyssins, accompagnement a l'adoption, disponibilites claires et contact direct avec la proprietaire."
        ),
        'og_image' => env('CHATTERIE_OG_IMAGE', 'images/soleils-orient-emblem.png'),
    ],

    'socials' => [
        'instagram' => env('CHATTERIE_INSTAGRAM_URL'),
        'facebook' => env('CHATTERIE_FACEBOOK_URL'),
    ],

    'whatsapp' => [
        'number' => env('WHATSAPP_NUMBER', '212XXXXXXXXX'),
        'default_text' => env('WHATSAPP_DEFAULT_TEXT', "Bonjour, je souhaite obtenir plus d'informations."),
    ],

    'legal' => [
        'host_name' => env('CHATTERIE_HOST_NAME'),
        'host_url' => env('CHATTERIE_HOST_URL'),
        'siret' => env('CHATTERIE_SIRET'),
        'vat' => env('CHATTERIE_VAT'),
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

    'public_statuses' => ['available', 'reserved'],

    'commitments' => [
        'Socialisation quotidienne dans un environnement familial calme et securise.',
        "Suivi de sante rigoureux, transparence sur l'etat et l'evolution de chaque chat.",
        "Accompagnement avant, pendant et apres l'adoption pour choisir le bon foyer.",
    ],

    'adoption_steps' => [
        'Premier echange pour comprendre votre mode de vie et vos attentes.',
        'Presentation des chats disponibles ou reserves selon le profil recherche.',
        "Validation du foyer, conseils de preparation et suivi apres l'arrivee.",
    ],
];
