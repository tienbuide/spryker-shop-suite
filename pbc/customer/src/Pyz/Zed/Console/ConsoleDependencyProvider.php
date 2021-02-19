<?php

namespace Pyz\Zed\Console;

use Spryker\Zed\Console\ConsoleDependencyProvider as SprykerConsoleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Propel\Communication\Console\BuildModelConsole;
use Spryker\Zed\Propel\Communication\Console\BuildSqlConsole;
use Spryker\Zed\Propel\Communication\Console\ConvertConfigConsole;
use Spryker\Zed\Propel\Communication\Console\CreateDatabaseConsole;
use Spryker\Zed\Propel\Communication\Console\DiffConsole;
use Spryker\Zed\Propel\Communication\Console\EntityTransferGeneratorConsole;
use Spryker\Zed\Propel\Communication\Console\InsertSqlConsole;
use Spryker\Zed\Propel\Communication\Console\MigrateConsole;
use Spryker\Zed\Propel\Communication\Console\MigrationCheckConsole;
use Spryker\Zed\Propel\Communication\Console\PostgresqlCompatibilityConsole;
use Spryker\Zed\Propel\Communication\Console\PropelInstallConsole;
use Spryker\Zed\Propel\Communication\Console\SchemaCopyConsole;
use Spryker\Zed\Propel\Communication\Plugin\Application\PropelApplicationPlugin;
use Spryker\Zed\Router\Communication\Plugin\Console\RouterCacheWarmUpConsole;
use Spryker\Zed\Router\Communication\Plugin\Console\RouterDebugZedConsole;
use Spryker\Zed\Transfer\Communication\Console\RemoveTransferConsole;
use Spryker\Zed\Transfer\Communication\Console\TransferGeneratorConsole;

class ConsoleDependencyProvider extends SprykerConsoleDependencyProvider
{
    protected const COMMAND_SEPARATOR = ':';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Symfony\Component\Console\Command\Command[]
     */
    protected function getConsoleCommands(Container $container): array
    {
        return [
            new TransferGeneratorConsole(),
            new RemoveTransferConsole(),
            new RouterDebugZedConsole(),
            new RouterCacheWarmUpConsole(),

            // Propel
            new PropelInstallConsole(),
            new EntityTransferGeneratorConsole(),
            new PostgresqlCompatibilityConsole(),
            new BuildModelConsole(),
            new BuildSqlConsole(),
            new CreateDatabaseConsole(),
            new DiffConsole(),
            new InsertSqlConsole(),
            new MigrateConsole(),
            new SchemaCopyConsole(),
            new MigrationCheckConsole(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface[]
     */
    public function getApplicationPlugins(Container $container): array
    {
        $applicationPlugins = parent::getApplicationPlugins($container);
        $applicationPlugins[] = new PropelApplicationPlugin();

        return $applicationPlugins;
    }
}
