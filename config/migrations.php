<?php

declare(strict_types=1);

if (getenv('MIGRATIONS_PATH') === false) {
    echo "\e[0;31;42m MIGRATIONS_PATH isn't found. This variable contains the path with migrations. Please add MIGRATIONS_PATH environment variable!\e[0m\n";

    exit(1);
}

if (getenv('MIGRATIONS_NAMESPACE') === false) {
    echo "\e[0;31;42m MIGRATIONS_NAMESPACE isn't found. This variable contains in the namespace name to create the migration. Please add MIGRATIONS_NAMESPACE environment variable! \e[0m\n";

    exit(1);
}

return [
    'table_storage' => [
        'table_name' => 'doctrine_migration_versions',
        'version_column_name' => 'version',
        'version_column_length' => 1024,
        'executed_at_column_name' => 'executed_at',
        'execution_time_column_name' => 'execution_time',
    ],
    'migrations_paths' => [
        getenv('MIGRATIONS_NAMESPACE') => getenv('MIGRATIONS_PATH'),
    ],
    'all_or_nothing' => true,
    'check_database_platform' => true,
    'organize_migrations' => 'none',
];