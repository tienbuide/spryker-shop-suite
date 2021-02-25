<?php


namespace Pyz\Client\Customer;
use Pyz\Client\Customer\Zed\CustomerStub;
use Spryker\Client\Customer\CustomerDependencyProvider;
use Spryker\Client\Customer\CustomerFactory as SprykerCustomerFactory;

class CustomerFactory extends SprykerCustomerFactory
{
    public function createZedCustomerStub()
    {
        // to change URL of Zed gateway CustomerStub should be overwritten.
        return new CustomerStub($this->getProvidedDependency(CustomerDependencyProvider::SERVICE_ZED));
    }
}
