<?php

namespace Kanboard\Plugin\DatabaseStorage\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS `object_storage` (
        `object_key` VARCHAR(255) NOT NULL,
        `object_data` LONGBLOB NOT NULL,
        PRIMARY KEY (`object_key`)
      ) ENGINE=InnoDB
    ');
}
