<?php

namespace Kanboard\Plugin\DatabaseStorage\Command;

use Kanboard\Console\BaseCommand;
use Kanboard\Core\ObjectStorage\ObjectStorageException;
use Kanboard\Plugin\DatabaseStorage\DatabaseObjectStorage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('db-storage:migrate')
            ->setDescription('Migrate local files to the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (! file_exists(FILES_DIR)) {
            $output->writeln('<error>Directory not found: '.FILES_DIR.'</error>');
        } else {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(FILES_DIR), RecursiveIteratorIterator::SELF_FIRST);
            $storage = new DatabaseObjectStorage($this->container['db']);;

            foreach($files as $file) {
                if ($file->getFilename(){0} !== '.' && ! $file->isDir()) {
                    $key = substr($file->getRealPath(), strlen(FILES_DIR) + 1);

                    if (! $this->fileExists($storage, $key)) {
                        $output->writeln('<info>Migrating '.$file->getFilename().'</info>');
                        $blob = $this->readFile($file->getRealPath());
                        $storage->put($key, $blob);
                    }
                }
            }
        }
    }

    protected function fileExists(DatabaseObjectStorage $storage, $key)
    {
        try {
            $storage->get($key);
            return true;
        } catch (ObjectStorageException $e) {}

        return false;
    }

    protected function readFile($filename)
    {
        $handle = fopen($filename, 'rb');
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        return $contents;
    }
}
