<?php

return [
    'pki' => [
        'scheme' => 'http://',
        'domain' => 'pki.edus.kz',
        'port' => 14141,
        'version' => '1.0',
        'timeout' => 120
    ],
    'stat' => [
        'scheme' => 'https://',
        'domain' => 'stat.gov.kz',
        'timeout' => 120
    ],
    'smsc' => [
        "route" => "https://smsc.kz/sys/send.php?login=".env('SMSC_LOGIN', 'undefined')."&psw=".env('SMSC_PASSWORD', 'undefined')."&fmt=3",
    ]
];