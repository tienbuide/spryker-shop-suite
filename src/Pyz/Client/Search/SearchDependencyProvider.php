<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\Search;

use Spryker\Client\Catalog\Plugin\Config\CatalogSearchConfigBuilder;
use Spryker\Client\Kernel\Container;
use Spryker\Client\MerchantProductOfferSearch\Plugin\Search\MerchantNameSearchConfigExpanderPlugin;
use Spryker\Client\MerchantProductSearch\Plugin\Search\MerchantProductMerchantNameSearchConfigExpanderPlugin;
use Spryker\Client\ProductSearchConfigStorage\Plugin\Config\ProductSearchConfigExpanderPlugin;
use Spryker\Client\Search\SearchDependencyProvider as SprykerSearchDependencyProvider;
use Spryker\Client\SearchElasticsearch\Plugin\ElasticsearchSearchAdapterPlugin;
use Spryker\Client\SearchElasticsearch\Plugin\ElasticsearchSearchContextExpanderPlugin;

class SearchDependencyProvider extends SprykerSearchDependencyProvider
{
    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\SearchConfigBuilderInterface
     */
    protected function createSearchConfigBuilderPlugin(Container $container)
    {
        return new CatalogSearchConfigBuilder();
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\SearchConfigExpanderPluginInterface[]
     */
    protected function createSearchConfigExpanderPlugins(Container $container): array
    {
        $searchConfigExpanderPlugins = parent::createSearchConfigExpanderPlugins($container);

        $searchConfigExpanderPlugins[] = new ProductSearchConfigExpanderPlugin();
        $searchConfigExpanderPlugins[] = new MerchantNameSearchConfigExpanderPlugin();
        $searchConfigExpanderPlugins[] = new MerchantProductMerchantNameSearchConfigExpanderPlugin();

        return $searchConfigExpanderPlugins;
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\SearchAdapterPluginInterface[]
     */
    protected function getClientAdapterPlugins(): array
    {
        return [
            new ElasticsearchSearchAdapterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\SearchContextExpanderPluginInterface[]
     */
    protected function getSearchContextExpanderPlugins(): array
    {
        return [
            new ElasticsearchSearchContextExpanderPlugin(),
        ];
    }
}
