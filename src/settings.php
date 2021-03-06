<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'dabase_default' => [
            'dbhost' => '.',
            'dbname' => 'KFVIDA',
            'dbuser' => 'sa',
            'dbpasswd' => '123456'
        ],

        'mailer' =>[
            'host' => "smtp.gmail.com",
            'username' => "ebertunerg@gmail.com",
            'password' => "123Enclave.21978",
            'smtpsecure' => "ssl",
            'port' => 465,
            'urlactivate' => 'http://localhost:4200/#/activar'
        ]
    ],
];
