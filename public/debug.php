<?php
// File debug sementara - HAPUS setelah deployment berhasil
echo json_encode([
    'APP_KEY_SET'   => !empty(getenv('APP_KEY')),
    'APP_KEY_LEN'   => strlen(getenv('APP_KEY') ?: ''),
    'DB_HOST'       => getenv('DB_HOST') ?: 'NOT SET',
    'DB_PORT'       => getenv('DB_PORT') ?: 'NOT SET',
    'DB_DATABASE'   => getenv('DB_DATABASE') ?: 'NOT SET',
    'DB_USERNAME'   => getenv('DB_USERNAME') ?: 'NOT SET',
    'DB_PASSWORD_SET' => !empty(getenv('DB_PASSWORD')),
    'APP_ENV'       => getenv('APP_ENV') ?: 'NOT SET',
    'PORT'          => getenv('PORT') ?: 'NOT SET',
    'STORAGE_WRITABLE' => is_writable(__DIR__ . '/../storage'),
    'BOOTSTRAP_WRITABLE' => is_writable(__DIR__ . '/../bootstrap/cache'),
    'ENV_FILE_EXISTS' => file_exists(__DIR__ . '/../.env'),
    'PHP_VERSION'   => PHP_VERSION,
], JSON_PRETTY_PRINT);
