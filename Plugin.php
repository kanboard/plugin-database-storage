<?php

namespace Kanboard\Plugin\DatabaseStorage;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        $this->container['objectStorage'] = function() {
            return new DatabaseObjectStorage($this->db);
        };
    }

    public function getPluginName()
    {
        return 'Database Storage';
    }

    public function getPluginDescription()
    {
        return 'Use the database to store attachments';
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-database-storage';
    }
}
