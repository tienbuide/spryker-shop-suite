<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\CheckoutDataRestApi\RestApi;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Generated\Shared\Transfer\StockProductTransfer;
use PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 * @group PyzTest
 * @group Glue
 * @group CheckoutDataRestApi
 * @group RestApi
 * @group CheckoutDataRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CheckoutDataRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    protected const TEST_PASSWORD = 'test password';

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransfer;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected $productConcreteTransfer;

    /**
     * @var \Generated\Shared\Transfer\ShipmentMethodTransfer
     */
    protected $shipmentMethodTransfer;

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\ShipmentMethodTransfer
     */
    public function getShipmentMethodTransfer(): ShipmentMethodTransfer
    {
        return $this->shipmentMethodTransfer;
    }

    /**
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(CheckoutDataRestApiTester $I): FixturesContainerInterface
    {
        $this->createCustomer($I);
        $this->createProductConcrete($I);
        $this->createShipmentMethod($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    protected function createCustomer(CheckoutDataRestApiTester $I): void
    {
        $customerTransfer = $I->haveCustomer([
            'password' => static::TEST_PASSWORD,
        ]);

        $customerTransfer->setNewPassword(static::TEST_PASSWORD);

        $this->customerTransfer = $customerTransfer;
    }

    /**
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    protected function createProductConcrete(CheckoutDataRestApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();
        $I->haveProductInStock([
            StockProductTransfer::SKU => $this->productConcreteTransfer->getSku(),
        ]);
        $I->havePriceProduct([
            PriceProductTransfer::SKU_PRODUCT => $this->productConcreteTransfer->getSku(),
            PriceProductTransfer::ID_PRODUCT => $this->productConcreteTransfer->getIdProductConcrete(),
            PriceProductTransfer::SKU_PRODUCT_ABSTRACT => $this->productConcreteTransfer->getAbstractSku(),
        ]);
    }

    /**
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    protected function createShipmentMethod(CheckoutDataRestApiTester $I): void
    {
        $this->shipmentMethodTransfer = $I->haveShipmentMethod();
    }
}
