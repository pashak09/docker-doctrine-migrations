<?php

declare(strict_types=1);

if (getenv('DATABASE_URL') === false) {
    echo "\e[0;31;42m DATABASE_URL isn't found. Please add DATABASE_URL environment variable!\e[0m\n";

    exit(1);
}

$DATABASE_URL = parse_url(getenv('DATABASE_URL'));

if (!isset($DATABASE_URL['path'], $DATABASE_URL['user'], $DATABASE_URL['pass'], $DATABASE_URL['host'], $DATABASE_URL['scheme'])) {
    echo "\e[0;31;42m DATABASE_URL isn't valid. Please use a valid DATABASE_URL.\n Example DATABASE_URL=mysql://user:pass@db/app!\e[0m\n";

    exit(1);
}

$OPTION_CONFIG_MAPPER = [
    'drivers' => [
        'mysql'    => 'pdo_mysql',
        'postgres' => 'pdo_pgsql',
    ],
    'ports' => [
        'mysql'    => 3306,
        'postgres' => 5432,
    ],
];

return [
    'dbname'   => trim($DATABASE_URL['path'], '/'),
    'user'     => $DATABASE_URL['user'],
    'password' => $DATABASE_URL['pass'],
    'host'     => $DATABASE_URL['host'],
    'port'     => $OPTION_CONFIG_MAPPER['ports'][$DATABASE_URL['scheme']] ?? $OPTION_CONFIG_MAPPER['ports'] ?? null,
    'driver'   => $OPTION_CONFIG_MAPPER['drivers'][$DATABASE_URL['scheme']] ?? $DATABASE_URL['scheme'],
];
