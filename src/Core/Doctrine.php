<?php


namespace App\Core;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class Doctrine
{
    private $entityManager;

    public function __construct()
    {
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__ . "/../Model/"], $isDevMode);

        $dbParams = [
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => 'root',
            'host' => 'localhost:8889',
            'dbname' => 'fullstack'
        ];

        try {
            $this->entityManager = EntityManager::create($dbParams, $config);
        } catch (ORMException $e) {
            echo $e;
        }
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}