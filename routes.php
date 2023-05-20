<?php

//  archivo de rutas...
return [
    ['GET', '/', ['InicioController', 'index']],
    ['POST', '/auth', ['AuthController', 'index']],
    ['GET', '/auth_tiktok', ['SocialMedia\Auth\TiktokAuthController', 'index']],
    ['POST','/files/uploads',['FileUploaderController','index']],
    [
        'GROUP', '/twitter', [
            ['GET', '/token', ['SocialMedia\Auth\TwitterTokenController', 'index']],
            ['POST', '/callback', ['SocialMedia\Auth\TwitterTokenController', 'callback']],
            ['POST', '/post_twiiter', ['SocialMedia\Auth\TwitterTokenController', 'post_twiiter']],
            ['GET', '/get_data_user_twtter', ['SocialMedia\Auth\TwitterTokenController', 'get_data_user_twtter']],
        ]


    ],
    [
        'GROUP', '/images', [
            ['POST', '/upload', ['FileUploaderController', 'index']],
            ['POST', '/delete', ['FileUploaderController', 'eliminar']],

        ]
    ],
    [
        'GROUP', '/social_media', [
            ['POST', '/post', ['SocialMediaPostController', 'index']],


        ]
    ]
];
