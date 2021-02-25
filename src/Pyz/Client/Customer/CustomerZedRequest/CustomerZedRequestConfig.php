<?php


namespace Pyz\Client\Customer\CustomerZedRequest;

use Spryker\Client\ZedRequest\ZedRequestConfig;

class CustomerZedRequestConfig extends ZedRequestConfig
{
    public function getZedRequestBaseUrl()
    {
        // PBC application URL
        return 'http://customer.spryker.local';
    }

}

