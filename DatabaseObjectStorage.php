<?php

namespace Kanboard\Plugin\DatabaseStorage;

use Kanboard\Core\ObjectStorage\ObjectStorageException;
use Kanboard\Core\ObjectStorage\ObjectStorageInterface;
use PicoDb\Database;

/**
 * Database Object Storage
 *
 * @package  DatabaseStorage
 * @author   Frederic Guillot
 */
class DatabaseObjectStorage implements ObjectStorageInterface
{
    const TABLE = 'object_storage';

    /**
     * @var Database
     */
    protected $db;

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Fetch object contents
     *
     * @access public
     * @throws ObjectStorageException
     * @param  string  $key
     * @return string
     */
    public function get($key)
    {
        $contents = $this->db
            ->largeObject(self::TABLE)->eq('object_key', $key)
            ->findOneColumnAsString('object_data');

        if ($contents === false) {
            throw new ObjectStorageException('Object not found: '.$key);
        }

        return $contents;
    }

    /**
     * Save object
     *
     * @access public
     * @throws ObjectStorageException
     * @param  string  $key
     * @param  string  $blob
     */
    public function put($key, &$blob)
    {
        $result = $this->db->largeObject(self::TABLE)
            ->insertFromString('object_data', $blob, array('object_key' => $key));

        if ($result === false) {
            throw new ObjectStorageException('Unable to save object: '.$key);
        }
    }

    /**
     * Output directly object content
     *
     * @access public
     * @param  string  $key
     */
    public function output($key)
    {
        $fd = $this->db->largeObject(self::TABLE)->eq('object_key', $key)->findOneColumnAsStream('object_data');

        if (is_string($fd)) {
            echo $fd;
        } else {
            fpassthru($fd);
        }
    }

    /**
     * Move local file to object storage
     *
     * @access public
     * @throws ObjectStorageException
     * @param  string  $src_filename
     * @param  string  $key
     * @return boolean
     */
    public function moveFile($src_filename, $key)
    {
        $result = $this->db->largeObject(self::TABLE)
            ->insertFromFile('object_data', $src_filename, array('object_key' => $key));

        if ($result === false) {
            throw new ObjectStorageException('Unable to move this file: '.$src_filename);
        }

        return true;
    }

    /**
     * Move uploaded file to object storage
     *
     * @access public
     * @param  string  $filename
     * @param  string  $key
     * @return boolean
     */
    public function moveUploadedFile($filename, $key)
    {
        return $this->moveFile($filename, $key);
    }

    /**
     * Remove object
     *
     * @access public
     * @param  string  $key
     * @return boolean
     */
    public function remove($key)
    {
        return $this->db->table(self::TABLE)->eq('object_key', $key)->remove();
    }
}
