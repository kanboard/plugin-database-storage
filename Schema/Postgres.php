<?php

namespace Kanboard\Plugin\DatabaseStorage\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS object_storage (
        "object_key" VARCHAR(255) PRIMARY KEY,
        "object_data" BYTEA NOT NULL
    )');
}
