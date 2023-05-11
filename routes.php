<?php

//  archivo de rutas...
return [
    ['GET', '/', ['InicioController', 'index']],
    ['POST', '/auth', ['AuthController', 'index']],
    ['GET', '/auth_tiktok', ['TiktokAuthController', 'index']],
    [
        'GROUP', '/twitter', [
            ['GET', '/token', ['TwitterTokenController', 'index']],
            ['POST', '/callback', ['TwitterTokenController', 'callback']],
            ['POST', '/post_twiiter', ['TwitterTokenController', 'post_twiiter']],
            ['GET', '/get_data_user_twtter', ['TwitterTokenController', 'get_data_user_twtter']],
        ]


    ],
    [
        'GROUP', '/images', [
            ['POST', '/upload', ['ImageUploaderController', 'index']],
            ['POST', '/delete', ['ImageUploaderController', 'eliminar']],

        ]
    ],
    [
        'GROUP', '/social_media', [
            ['POST', '/post', ['SocialMediaPostController', 'index']],


        ]
    ]
];
