<?php

namespace MoveElevator\MeBackendSecurity\Factory;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * @package MoveElevator\MeBackendSecurity\Factory
 */
class DatabaseConnectionFactory
{
    /**
     * @param ObjectManager $objectManager
     * @param array $databaseConfiguration
     *
     * @return DatabaseConnection
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public static function create(ObjectManager $objectManager, $databaseConfiguration)
    {
        if (empty($databaseConfiguration['username']) ||
            empty($databaseConfiguration['password']) ||
            empty($databaseConfiguration['host']) ||
            empty($databaseConfiguration['port']) ||
            empty($databaseConfiguration['database'])
        ) {
            throw new \InvalidArgumentException(
                'The given arguments are incomplete!'
            );
        }

        return self::createDatabaseConnection($objectManager, $databaseConfiguration);
    }

    /**
     * @param ObjectManager $objectManager
     * @param array $databaseConfiguration
     *
     * @return DatabaseConnection
     */
    private static function createDatabaseConnection(ObjectManager $objectManager, $databaseConfiguration)
    {
        /** @var \TYPO3\CMS\Core\Database\DatabaseConnection $databaseConnection */
        $databaseConnection = $objectManager->get(DatabaseConnection::class);

        $databaseConnection->setDatabaseUsername((string) $databaseConfiguration['username']);
        $databaseConnection->setDatabasePassword((string) $databaseConfiguration['password']);
        $databaseConnection->setDatabaseHost((string) $databaseConfiguration['host']);
        $databaseConnection->setDatabasePort((string) $databaseConfiguration['port']);
        $databaseConnection->setDatabaseName((string) $databaseConfiguration['database']);

        if (empty($databaseConfiguration['socket']) === false) {
            $databaseConnection->setDatabaseSocket((string) $databaseConfiguration['socket']);
        }

        $databaseConnection->initialize();
        $databaseConnection->connectDB();

        if ($databaseConnection->isConnected() === false) {
            throw new \RuntimeException(
                'Could not connect to database server!'
            );
        }

        return $databaseConnection;
    }
}
