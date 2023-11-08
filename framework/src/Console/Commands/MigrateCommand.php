<?php

namespace SimplePhpFramework\Console\Commands;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use SimplePhpFramework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private string $name = 'migrate';
    private const MIGRATIONS_TABLE = 'migrations';

    public function __construct(
        private Connection $connection,
        private string $migrationsPath
    )
    {
    }

    public function execute(array $parameters = []): int
    {
        try {
            $this->connection->setAutoCommit(false);

            // 1. Створити таблицю міграцій (migrations), якщо таблиця ще не існує

            $this->createMigrationsTable();

            $this->connection->beginTransaction();

            // 2. Отримати $appliedMigrations (міграції, які вже є в таблиці migrations)

            $appliedMigrations = $this->getAppliedMigrations();

            // 3. Отримати $migrationFiles з папки міграцій

            $migrationFiles = $this->getMigrationFiles();


            // 4. Отримати міграції для використання

            $migrationsToApply = array_values(array_diff($migrationFiles, $appliedMigrations));

            $schema = new Schema();

            foreach ($migrationsToApply as $migration) {
                $migrationInstance = require $this->migrationsPath . "/$migration";

                // 5. Свтоирти SQL запит для міграцій, які ще не були виконані
                $migrationInstance->up($schema);

                // 6. Добавити міграцію в БД

                $this->addMigration($migration);
            }

            // 7. Виконати SQL-запит

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

            foreach ($sqlArray as $sql) {
                $this->connection->executeQuery($sql);
            }


            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();

            throw $e;
        }

        $this->connection->setAutoCommit(true);

        return 0;
    }

    private function createMigrationsTable(): void
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (! $schemaManager->tablesExist(self::MIGRATIONS_TABLE)) {
            $schema = new Schema();
            $table = $schema->createTable(self::MIGRATIONS_TABLE);
            $table->addColumn('id', Types::INTEGER, [
                'unsigned' => true,
                'autoincrement' => true,
            ]);
            $table->addColumn('migration', Types::STRING);
            $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, [
                'default' => 'CURRENT_TIMESTAMP',
            ]);
            $table->setPrimaryKey(['id']);

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

            $this->connection->executeQuery($sqlArray[0]);

            echo 'Migrations table created';
        }
    }

    private function getAppliedMigrations(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        return $queryBuilder
            ->select('migration')
            ->from(self::MIGRATIONS_TABLE)
            ->executeQuery()
            ->fetchFirstColumn();
    }

    private function getMigrationFiles(): array
    {
        $migrationFiles = scandir($this->migrationsPath);

        $filteredFiles = array_filter($migrationFiles, function ($fileName) {
            return ! in_array($fileName, ['.', '..']);
        });

        return array_values($filteredFiles);
    }

    private function addMigration(string $migration): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->insert(self::MIGRATIONS_TABLE)
            ->values(['migration' => ':migration'])
            ->setParameter('migration', $migration)
            ->executeQuery();
    }
}