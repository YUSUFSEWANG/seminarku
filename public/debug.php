<?php
// Debug file - HAPUS setelah berhasil
header('Content-Type: application/json');
echo json_encode([
    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
    'APP_KEY_SET'     => !empty(getenv('APP_KEY')),
    'APP_KEY_LEN'     => strlen(getenv('APP_KEY') ?: ''),
    'DB_HOST'         => getenv('DB_HOST') ?: (getenv('MYSQLHOST') ?: 'NOT SET'),
    'DB_PORT'         => getenv('DB_PORT') ?: (getenv('MYSQLPORT') ?: 'NOT SET'),
    'DB_DATABASE'     => getenv('DB_DATABASE') ?: (getenv('MYSQL_DATABASE') ?: 'NOT SET'),
    'DB_USERNAME'     => getenv('DB_USERNAME') ?: (getenv('MYSQLUSER') ?: 'NOT SET'),
    'DB_PASSWORD_SET' => !empty(getenv('DB_PASSWORD')) || !empty(getenv('MYSQLPASSWORD')),
    'MYSQLHOST'       => getenv('MYSQLHOST') ?: 'NOT SET',
    'MYSQL_URL_SET'   => !empty(getenv('MYSQL_URL')),
    'PORT'            => getenv('PORT') ?: 'NOT SET',
    'APP_ENV'         => getenv('APP_ENV') ?: 'NOT SET',
    'STORAGE_WRITABLE'   => is_writable(__DIR__ . '/../storage'),
    'BOOTSTRAP_WRITABLE' => is_writable(__DIR__ . '/../bootstrap/cache'),
    'ENV_FILE_EXISTS'    => file_exists(__DIR__ . '/../.env'),
    'PHP_VERSION'        => PHP_VERSION,
    'ALL_ENV_KEYS'       => array_keys(array_filter(getenv(), fn($v) => !empty($v))),
], JSON_PRETTY_PRINT);
