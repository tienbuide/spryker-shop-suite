<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\CheckoutDataRestApi\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester;
use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig;
use Spryker\Glue\ShipmentsRestApi\ShipmentsRestApiConfig;

/**
 * Auto-generated group annotations
 * @group PyzTest
 * @group Glue
 * @group CheckoutDataRestApi
 * @group RestApi
 * @group CheckoutDataRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CheckoutDataRestApiCest
{
    protected const NOT_EXISTED_ID_CART = 'NOT_EXISTED_ID_CART';

    /**
     * @var \PyzTest\Glue\CheckoutDataRestApi\RestApi\CheckoutDataRestApiFixtures
     */
    protected $fixtures;

    /**
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CheckoutDataRestApiTester $I): void
    {
        $this->fixtures = $I->loadFixtures(CheckoutDataRestApiFixtures::class);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    public function requestCheckoutDataByWhenCustomerIsNotLoggedInShouldBeFailed(CheckoutDataRestApiTester $I): void
    {
        $I->sendPOST(CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA, [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => static::NOT_EXISTED_ID_CART,
                ],
            ],
        ]);

        $this->assertCheckoutDataRequest($I, HttpCode::BAD_REQUEST);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    public function requestCheckoutDataByIdCartShouldBeSuccessful(CheckoutDataRestApiTester $I): void
    {
        $idCart = $I->createCartWithItems(
            $this->fixtures->getCustomerTransfer(),
            $this->fixtures->getProductConcreteTransfer()
        );

        $I->sendPOST(CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA, [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $idCart,
                ],
            ],
        ]);

        $this->assertCheckoutDataRequest($I, HttpCode::OK);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    public function requestCheckoutDataByIncorrectIdCartShouldBeFailed(CheckoutDataRestApiTester $I): void
    {
        $I->customerLogIn($this->fixtures->getCustomerTransfer());

        $I->sendPOST(CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA, [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => static::NOT_EXISTED_ID_CART,
                ],
            ],
        ]);

        $this->assertCheckoutDataRequest($I, HttpCode::UNPROCESSABLE_ENTITY);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    public function requestCheckoutDataByIdCartWithSelectedShipmentMethodShouldGetShipmentMethodDetails(
        CheckoutDataRestApiTester $I
    ): void {
        $idCart = $I->createCartWithItems(
            $this->fixtures->getCustomerTransfer(),
            $this->fixtures->getProductConcreteTransfer()
        );

        $I->sendPOST(CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA, [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $idCart,
                    'shipment' => [
                        'idShipmentMethod' => $this->fixtures->getShipmentMethodTransfer()->getIdShipmentMethod(),
                    ],
                ],
            ],
        ]);

        $this->assertCheckoutDataRequest($I, HttpCode::OK);
        $selectedShipmentMethods = $I
            ->grabDataFromResponseByJsonPath('$.data.attributes.selectedShipmentMethods')[0];
        $selectedShipmentMethod = $selectedShipmentMethods[0];

        $I->assertNotEmpty($selectedShipmentMethods);
        $I->assertNotEmpty($selectedShipmentMethod);
        $I->assertSame($selectedShipmentMethod['name'], $this->fixtures->getShipmentMethodTransfer()->getName());
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    public function requestCheckoutDataWithIncludedShipmentMethods(CheckoutDataRestApiTester $I): void
    {
        $idCart = $I->createCartWithItems(
            $this->fixtures->getCustomerTransfer(),
            $this->fixtures->getProductConcreteTransfer()
        );

        $url = sprintf('%s?include=%s', CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA, ShipmentsRestApiConfig::RESOURCE_SHIPMENT_METHODS);

        $I->sendPOST($url, [
            'data' => [
                'type' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
                'attributes' => [
                    'idCart' => $idCart,
                ],
            ],
        ]);

        $this->assertCheckoutDataRequestWithIncludedShipmentMethods($I);
    }

    /**
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     *
     * @return void
     */
    protected function assertCheckoutDataRequestWithIncludedShipmentMethods(
        CheckoutDataRestApiTester $I
    ): void {
        $idShipmentMethod = $this->fixtures->getShipmentMethodTransfer()->getIdShipmentMethod();

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource has shipment method in `relationships` section.')
            ->whenI()
            ->seeSingleResourceHasRelationshipByTypeAndId('shipment-methods', $idShipmentMethod);

        $I->amSure('Returned resource has shipment method in `included` section.')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(ShipmentsRestApiConfig::RESOURCE_SHIPMENT_METHODS, $idShipmentMethod);
    }

    /**
     * @param \PyzTest\Glue\CheckoutDataRestApi\CheckoutDataRestApiTester $I
     * @param int $responseCode
     *
     * @return void
     */
    protected function assertCheckoutDataRequest(
        CheckoutDataRestApiTester $I,
        int $responseCode
    ): void {
        $I->seeResponseCodeIs($responseCode);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }
}
