<?php

return [
    'email' => [
        'transport' => [
            'options' => [
                'name' => 'MailTrap',
                'host' => 'email',
                'port' => 1025,
            ],
            'type' => 'smtp',
        ],
        'fromAddress' => '<SENDER_EMAIL_ADDRESS>',
        'fromName' => '<SENDER_NAME>'
    ]
];