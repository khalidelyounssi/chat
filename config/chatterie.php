<?php

$adminEmails = array_values(array_filter(array_map(
    static fn (string $email): string => trim($email),
    explode(',', (string) env('ADMIN_EMAILS', env('ADMIN_EMAIL', 'admin@soleils-orient.test')))
)));

return [
    'admin' => [
        'emails' => $adminEmails,
    ],

    'seo' => [
        'primary_domain' => env('SEO_PRIMARY_DOMAIN'),
        'service_area' => array_values(array_filter(array_map(
            static fn (string $value): string => trim($value),
            explode(',', (string) env('SEO_SERVICE_AREAS', 'Saint-Ave,Vannes,Morbihan,Bretagne,France'))
        ))),
        'faq' => [
            [
                'question' => "Où se situe la chatterie des Soleils d'Orient ?",
                'answer' => 'La chatterie est située à Saint-Avé, dans le Morbihan, et accueille les familles sur prise de contact préalable.',
            ],
            [
                'question' => 'Quels chats sont visibles sur le site ?',
                'answer' => "Le site affiche les profils disponibles et, lorsque c'est utile, certains profils réservés. Les profils vendus ne sont pas présentés au public.",
            ],
            [
                'question' => "Comment se passe une première demande d'adoption ?",
                'answer' => 'Le premier échange sert à comprendre votre foyer, votre rythme de vie et le type de compagnon recherché afin de proposer un profil cohérent.',
            ],
            [
                'question' => 'Peut-on contacter la chatterie par WhatsApp ?',
                'answer' => 'Oui, un lien WhatsApp est disponible sur le site lorsque le numéro de contact est renseigné.',
            ],
        ],
    ],

    'site' => [
        'name' => env('CHATTERIE_NAME', env('APP_NAME', "Chatterie des Soleils d'Orient")),
        'owner_name' => env('CHATTERIE_OWNER_NAME', 'Mme KAYADELEN Sinem'),
        'tagline' => env('CHATTERIE_TAGLINE', "Chatterie d'Abyssins"),
        'city' => env('CHATTERIE_CITY', 'Saint-Avé'),
        'market_city' => env('CHATTERIE_MARKET_CITY', 'Vannes'),
        'country' => env('CHATTERIE_COUNTRY', 'France'),
        'phone' => env('CHATTERIE_PHONE', '06.51.09.03.36'),
        'email' => env('CHATTERIE_EMAIL', env('MAIL_FROM_ADDRESS', 'chatteriedessoleilsdorient@outlook.fr')),
        'hours' => env('CHATTERIE_HOURS', 'Du lundi au samedi, de 10h00 à 18h00'),
        'legal_name' => env('CHATTERIE_LEGAL_NAME', "Chatterie des Soleils d'Orient"),
        'legal_status' => env('CHATTERIE_LEGAL_STATUS', 'Élevage de chats abyssins'),
        'meta_description' => env(
            'CHATTERIE_META_DESCRIPTION',
            "Chatterie des Soleils d'Orient à Saint-Avé, proche de Vannes : élevage de chats abyssins, accompagnement à l'adoption, disponibilités claires et contact direct avec la propriétaire."
        ),
        'og_image' => env('CHATTERIE_OG_IMAGE', 'images/soleils-abyssins-emblem.png'),
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
        'reserved' => 'Réservé',
        'sold' => 'Vendu',
    ],

    'genders' => [
        'male' => 'Mâle',
        'female' => 'Femelle',
    ],

    'public_statuses' => ['available', 'reserved'],

    'commitments' => [
        'Socialisation quotidienne dans un environnement familial calme et sécurisé.',
        "Suivi de santé rigoureux, transparence sur l'état et l'évolution de chaque chat.",
        "Accompagnement avant, pendant et après l'adoption pour choisir le bon foyer.",
    ],

    'adoption_steps' => [
        'Premier échange pour comprendre votre mode de vie et vos attentes.',
        'Présentation des chats disponibles ou réservés selon le profil recherché.',
        "Validation du foyer, conseils de préparation et suivi après l'arrivée.",
    ],
];
