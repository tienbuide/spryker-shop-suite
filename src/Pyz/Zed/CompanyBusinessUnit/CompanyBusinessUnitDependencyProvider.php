<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CompanyBusinessUnit;

use Spryker\Zed\CompanyBusinessUnit\CompanyBusinessUnitDependencyProvider as SprykerCompanyBusinessUnitDependencyProvider;
use Spryker\Zed\CompanyUnitAddress\Communication\Plugin\CompanyBusinessUnit\CompanyBusinessUnitAddressesCompanyBusinessUnitExpanderPlugin;
use Spryker\Zed\CompanyUnitAddress\Communication\Plugin\CompanyBusinessUnitAddressSaverPlugin;
use Spryker\Zed\ShoppingList\Communication\Plugin\CompanyBusinessUnit\CompanyBusinessUnitPreDeletePlugin;

class CompanyBusinessUnitDependencyProvider extends SprykerCompanyBusinessUnitDependencyProvider
{
    /**
     * @return \Spryker\Zed\CompanyBusinessUnitExtension\Dependency\Plugin\CompanyBusinessUnitPostSavePluginInterface[]
     */
    protected function getCompanyBusinessUnitPostSavePlugins(): array
    {
        return [
            new CompanyBusinessUnitAddressSaverPlugin(),
        ];
    }

    /**
<<<<<<< HEAD
     * @return \Spryker\Zed\CompanyBusinessUnitExtension\Dependency\Plugin\CompanyBusinessUnitExpanderPluginInterface[]
     */
    protected function getCompanyBusinessUnitExpanderPlugins(): array
    {
        return [
            new CompanyBusinessUnitAddressesCompanyBusinessUnitExpanderPlugin(),
=======
     * @return \Spryker\Zed\CompanyBusinessUnitExtension\Dependency\Plugin\CompanyBusinessUnitPreDeletePluginInterface[]
     */
    protected function getCompanyBusinessUnitPreDeletePlugins(): array
    {
        return [
            new CompanyBusinessUnitPreDeletePlugin(),
>>>>>>> origin/master
        ];
    }
}
