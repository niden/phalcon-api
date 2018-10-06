<?php

use function Niden\Core\appPath;
use function Niden\Core\envValue;

return [
    'application' => [ //@todo migration to app
        'production ' => getenv('PRODUCTION'),
        'development ' => getenv('DEVELOPMENT'),
        'jwtSecurity' => getenv('JWT_SECURITY'),
        'debug' => [
            'profile' => getenv('DEBUG_PROFILE'),
            'logQueries' => getenv('DEBUG_QUERY'),
            'logRequest' => getenv('DEBUG_REQUEST')
        ],
    ],
    'app' => [
        'version' => envValue('VERSION', time()),
        'timezone' => envValue('APP_TIMEZONE', 'UTC'),
        'debug' => envValue('APP_DEBUG', false),
        'env' => envValue('APP_ENV', 'development'),
        'devMode' => boolval(
            'development' === envValue('APP_ENV', 'development')
        ),
        'baseUri' => envValue('APP_BASE_URI'),
        'supportEmail' => envValue('APP_SUPPORT_EMAIL'),
        'time' => microtime(true),
        'namespaceName' => envValue('APP_NAMESPACE'),
    ],
    'cache' => [
        'data' => [
            'front' => [
                'adapter' => 'Data',
                'options' => [
                    'lifetime' => envValue('CACHE_LIFETIME'),
                ],
            ],
            'back' => [
                'dev' => [
                    'adapter' => 'File',
                    'options' => [
                        'cacheDir' => appPath('storage/cache/data/'),
                    ],
                ],
                'prod' => [
                    'adapter' => 'Libmemcached',
                    'options' => [
                        'servers' => [
                            [
                                'host' => envValue('DATA_API_MEMCACHED_HOST'),
                                'port' => envValue('DATA_API_MEMCACHED_PORT'),
                                'weight' => envValue('DATA_API_MEMCACHED_WEIGHT'),
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'metadata' => [
            'dev' => [
                'adapter' => 'Memory',
                'options' => [],
            ],
            'prod' => [
                'adapter' => 'Files',
                'options' => [
                    'metaDataDir' => appPath('storage/cache/metadata/'),
                ],
            ],
        ],
    ],
    'email' => [
        'driver' => 'smtp',
        'host' => envValue('EMAIL_HOST'),
        'port' => envValue('EMAIL_PORT'),
        'username' => envValue('EMAIL_USER'),
        'password' => envValue('EMAIL_PASS'),
        'from' => [
            'email' => envValue('EMAIL_FROM_PRODUCTION'),
            'name' => envValue('EMAIL_FROM_NAME_PRODUCTION'),
        ],
        'debug' => [
            'from' => [
                'email' => envValue('EMAIL_FROM_DEBUG'),
                'name' => envValue('EMAIL_FROM_NAME_DEBUG'),
            ],
        ],
    ],
    'jwt' => [
        'secretKey' => envValue('APP_JWT_TOKEN'),
        'payload' => [
            'exp' => 1440,
            'iss' => 'phalcon-jwt-auth',
        ],
        'ignoreUri' => [
            '/v1',
        ],
    ],
];
