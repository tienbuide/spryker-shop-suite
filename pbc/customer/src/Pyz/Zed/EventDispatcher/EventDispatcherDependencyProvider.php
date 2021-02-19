<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\EventDispatcher;

use Spryker\Shared\Http\Plugin\EventDispatcher\ResponseListenerEventDispatcherPlugin;
use Spryker\Zed\Application\Communication\Plugin\EventDispatcher\HeadersSecurityEventDispatcherPlugin;
use Spryker\Zed\EventDispatcher\EventDispatcherDependencyProvider as SprykerEventDispatcherDependencyProvider;
use Spryker\Zed\Http\Communication\Plugin\EventDispatcher\CookieEventDispatcherPlugin;
use Spryker\Zed\Http\Communication\Plugin\EventDispatcher\FragmentEventDispatcherPlugin;
use Spryker\Zed\Http\Communication\Plugin\EventDispatcher\HeaderEventDispatcherPlugin;
use Spryker\Zed\Http\Communication\Plugin\EventDispatcher\HstsHeaderEventDispatcher;
use Spryker\Zed\Kernel\Communication\Plugin\AutoloaderCacheEventDispatcherPlugin;
use Spryker\Zed\Locale\Communication\Plugin\EventDispatcher\LocaleEventDispatcherPlugin;
use Spryker\Zed\Router\Communication\Plugin\EventDispatcher\RequestAttributesEventDispatcherPlugin;
use Spryker\Zed\Router\Communication\Plugin\EventDispatcher\RouterListenerEventDispatcherPlugin;
use Spryker\Zed\Router\Communication\Plugin\EventDispatcher\RouterLocaleEventDispatcherPlugin;
use Spryker\Zed\ZedRequest\Communication\Plugin\EventDispatcher\GatewayControllerEventDispatcherPlugin;

class EventDispatcherDependencyProvider extends SprykerEventDispatcherDependencyProvider
{
    /**
     * @return \Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface[]
     */
    protected function getEventDispatcherPlugins(): array
    {
        return [
            new GatewayControllerEventDispatcherPlugin(),
            new HeadersSecurityEventDispatcherPlugin(),
            new LocaleEventDispatcherPlugin(),
            new RouterLocaleEventDispatcherPlugin(),
            new RouterListenerEventDispatcherPlugin(),
            //new RouterSslRedirectEventDispatcherPlugin(),
            new CookieEventDispatcherPlugin(),
            new FragmentEventDispatcherPlugin(),
            new HeaderEventDispatcherPlugin(),
            new HstsHeaderEventDispatcher(),
            new AutoloaderCacheEventDispatcherPlugin(),
            new RequestAttributesEventDispatcherPlugin(),
            new ResponseListenerEventDispatcherPlugin(),
        ];
    }
}
