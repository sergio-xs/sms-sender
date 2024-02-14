<?php

return [
    'providers' => [
        'toky-digital' => [
            'username' => '1MMPnyD8JPwr9skRHzxj',
            'password' => 'HPxFDw0KkUZvYDDaPbjs',
            'base_url' => 'http://54.36.76.186/sms/httpGateway/SendMessage.aspx',
            'countries' => [
                'IT', 'UK', 'FR', 'USA', 'DE', 'ZV',
            ]
        ],
        'gsm-boxes' => [
            'Gsm Box 1 ITALIA' => [
                'name' => 'Gsm Box 1 ITALIA',
                'url' => 'url',
                'username' => 'username',
                'password' => 'password',
                'port' => [
                    '1A',
                    '2A',
                    '3A',
                    '4A',
                    '5A',
                    '6A',
                    '7A',
                ],
            ],
            'gsm-box-2' => [
                'name' => 'gsm-box-2',
                'url' => 'url',
                'username' => 'username',
                'password' => 'password',
                'port' => [
                    '1A',
                    '2A',
                    '3A',
                    '4A',
                    '5A',
                    '6A',
                    '7A',
                ],
            ],
            'gsm-box-3' => [
                'name' => 'gsm-box-3',
                'url' => 'url',
                'username' => 'username',
                'password' => 'password',
                'port' => [
                    '1A',
                    '2A',
                    '3A',
                    '4A',
                    '5A',
                    '6A',
                    '7A',
                ],
            ],
            'gsm-box-blikudo' => [
                'name' => 'gsm-box-blikudo',
                'url' => env('SMS_SENDER_URL', 'http://192.168.10.55/goip_send_sms.html'),
                'username' => env('SMS_SENDER_USERNAME', 'sms'),
                'password' => env('SMS_SENDER_PASSWORD', 'mx89xyyp1gpq5'),
                'port' => ['1A', '7A'],
            ]
        ]
    ]
];
