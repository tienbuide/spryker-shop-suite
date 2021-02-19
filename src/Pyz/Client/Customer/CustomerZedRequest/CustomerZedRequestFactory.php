<?php


namespace Pyz\Client\Customer\CustomerZedRequest;

use Pyz\Client\ZedRequest\ZedRequestDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException;
use Spryker\Client\ZedRequest\ZedRequestFactory;

class CustomerZedRequestFactory extends ZedRequestFactory
{
     private $config;

     public function getConfig()
     {
         if ($this->config === null) {
             $this->config = new CustomerZedRequestConfig();
         }

         return $this->config;
     }

    /**
     * @return \Spryker\Shared\ZedRequest\Client\AbstractZedClientInterface
     */
    public function getCashedClient()
    {
        // To avoid caching customer Zed client
        return $this->createClient();
    }


    /**
     * @param string $key
     *
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return mixed
     */
    protected function getProvidedDependency($key)
    {
        $container = $this->getContainer();

        if ($container->has($key) === false) {
            throw new ContainerKeyNotFoundException($this, $key);
        }

        return $container->get($key);
    }

    /**
     * @return \Spryker\Client\Kernel\Container
     */
    protected function getContainer(): Container
    {
        $containerKey = ZedRequestFactory::class;

        if (!isset(static::$containers[$containerKey])) {
            static::$containers[$containerKey] = $this->createContainerWithProvidedDependencies();
        }

        return static::$containers[$containerKey];
    }

    /**
     * @return \Spryker\Client\Kernel\AbstractDependencyProvider
     */
    protected function resolveDependencyProvider()
    {
        return new ZedRequestDependencyProvider();
    }
}
