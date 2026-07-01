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
                'question' => "Ou se situe la chatterie des Soleils d'Orient ?",
                'answer' => 'La chatterie est situee a Saint-Ave, dans le Morbihan, et accueille les familles sur prise de contact prealable.',
            ],
            [
                'question' => 'Quels chats sont visibles sur le site ?',
                'answer' => "Le site affiche les profils disponibles et, lorsque c'est utile, certains profils reserves. Les profils vendus ne sont pas presentes au public.",
            ],
            [
                'question' => "Comment se passe une premiere demande d'adoption ?",
                'answer' => 'Le premier echange sert a comprendre votre foyer, votre rythme de vie et le type de compagnon recherche afin de proposer un profil coherent.',
            ],
            [
                'question' => 'Peut-on contacter la chatterie par WhatsApp ?',
                'answer' => 'Oui, un lien WhatsApp est disponible sur le site lorsque le numero de contact est renseigne.',
            ],
        ],
    ],

    'site' => [
        'name' => env('CHATTERIE_NAME', env('APP_NAME', "Chatterie des Soleils d'Orient")),
        'owner_name' => env('CHATTERIE_OWNER_NAME', 'Mme KAYADELEN Sinem'),
        'tagline' => env('CHATTERIE_TAGLINE', "Chatterie d'Abyssins"),
        'city' => env('CHATTERIE_CITY', 'Saint-Ave'),
        'market_city' => env('CHATTERIE_MARKET_CITY', 'Vannes'),
        'country' => env('CHATTERIE_COUNTRY', 'France'),
        'address' => env('CHATTERIE_ADDRESS', '16B Rue Joseph le Brix, 56890 Saint-Ave'),
        'phone' => env('CHATTERIE_PHONE', '06.51.09.03.36'),
        'email' => env('CHATTERIE_EMAIL', env('MAIL_FROM_ADDRESS', 'chatteriedessoleilsdorient@outlook.fr')),
        'hours' => env('CHATTERIE_HOURS', 'Du lundi au samedi, de 10h00 a 18h00'),
        'legal_name' => env('CHATTERIE_LEGAL_NAME', "Chatterie des Soleils d'Orient"),
        'legal_status' => env('CHATTERIE_LEGAL_STATUS', 'Elevage de chats abyssins'),
        'meta_description' => env(
            'CHATTERIE_META_DESCRIPTION',
            "Chatterie des Soleils d'Orient a Saint-Ave, proche de Vannes : elevage de chats abyssins, accompagnement a l'adoption, disponibilites claires et contact direct avec la proprietaire."
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
