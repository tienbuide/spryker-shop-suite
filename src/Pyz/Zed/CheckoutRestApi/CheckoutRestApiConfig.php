<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CheckoutRestApi;

use Spryker\Zed\CheckoutRestApi\CheckoutRestApiConfig as SprykerCheckoutRestApiConfig;

class CheckoutRestApiConfig extends SprykerCheckoutRestApiConfig
{
    /**
     * @return bool
     */
    public function deleteCartAfterOrderCreation()
    {
        return false;
    }
}
