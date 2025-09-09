<?php
namespace App\EventListener;

use Doctrine\DBAL\Event\ConnectionEventArgs;

class SqliteForeignKeyListener
{
    public function postConnect(ConnectionEventArgs $args): void
    {
        $conn = $args->getConnection();
        if ($conn->getDatabasePlatform()->getName() === 'sqlite') {
            $conn->executeQuery('PRAGMA foreign_keys = ON');
        }
    }
}