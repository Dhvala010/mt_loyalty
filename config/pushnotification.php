<?php
/**
 * @see https://github.com/Edujugon/PushNotification
 */

return [
    'gcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'My_ApiKey',
    ],
    'fcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'eIgRyFkJ8-A:APA91bHYpKVWFVIdRJc24Qle4H1nSW2QZDZ2RmG5Hy5Xcz3pPAaHFJLZtootr64NT0vzraajrA_mANjoIV6K3T6Te6XpDDHgyQLfUrhYaYy_JalADujWZvKLhzg9sObd5ELvXPP4Cpjc',
    ],
    'apn' => [
        'certificate' => __DIR__ . '/iosCertificates/apns-dev-cert.pem',
        'passPhrase' => 'secret', //Optional
        'passFile' => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
        'dry_run' => true,
    ],
];
