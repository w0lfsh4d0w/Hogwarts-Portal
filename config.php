<?php

return [
    'database' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => getenv('DB_PORT') ?: 3306,
        'dbname' => getenv('DB_DATABASE') ?: 'hogwarts_db',
        'charset' => 'utf8mb4',
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: 'MyRoot@1234',
    ]
];
