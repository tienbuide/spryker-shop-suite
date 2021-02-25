<?php
namespace Pyz\Client\Customer\Zed;

use Pyz\Client\Customer\CustomerZedRequest\CustomerZedRequestFactory;
use Spryker\Client\Customer\Zed\CustomerStub as SprykerCustomerStub;
use Spryker\Client\ZedRequest\ZedRequestClient;

class CustomerStub extends SprykerCustomerStub
{
    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClient $zedStub
     */
    public function __construct(ZedRequestClient $zedStub)
    {
        parent::__construct($zedStub);

        // ZedRequest with changed Zed gateway URL
        $this->zedStub->setFactory(new CustomerZedRequestFactory());
    }
}
