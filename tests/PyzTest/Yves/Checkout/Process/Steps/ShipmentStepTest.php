<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Checkout\Process\Steps;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\ExpenseBuilder;
use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\DataBuilder\ShipmentBuilder;
use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use Spryker\Shared\Shipment\ShipmentConstants;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface;
use SprykerShop\Yves\CheckoutPage\CheckoutPageDependencyProvider;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCalculationClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Service\CheckoutPageToShipmentServiceBridge;
use SprykerShop\Yves\CheckoutPage\Process\Steps\ShipmentStep;
use SprykerShop\Yves\CheckoutPage\Process\Steps\ShipmentStep\PostConditionChecker;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 * @group PyzTest
 * @group Yves
 * @group Checkout
 * @group Process
 * @group Steps
 * @group ShipmentStepTest
 * Add your own group annotations below this line
 */
class ShipmentStepTest extends Unit
{
    use LocatorHelperTrait;

    /**
     * @return void
     */
    public function testShipmentStepExecuteShouldTriggerPlugins()
    {
        $shipmentPluginMock = $this->createShipmentMock();
        $shipmentPluginMock->expects($this->once())->method('addToDataClass');

        $shipmentStepHandler = new StepHandlerPluginCollection();
        $shipmentStepHandler->add($shipmentPluginMock, CheckoutPageDependencyProvider::PLUGIN_SHIPMENT_STEP_HANDLER);
        $shipmentStep = $this->createShipmentStep($shipmentStepHandler);

        $quoteTransfer = new QuoteTransfer();

        $shipmentTransfer = new ShipmentTransfer();
        $shipmentTransfer->setShipmentSelection(CheckoutPageDependencyProvider::PLUGIN_SHIPMENT_STEP_HANDLER);
        $quoteTransfer->setShipment($shipmentTransfer);

        $shipmentStep->execute($this->createRequest(), $quoteTransfer);
    }

    /**
     * @return void
     */
    public function testShipmentStepExecuteShouldTriggerPluginsWithItemLevelShipments()
    {
        $shipmentPluginMock = $this->createShipmentMock();
        $shipmentPluginMock->expects($this->once())->method('addToDataClass');

        $shipmentStepHandler = new StepHandlerPluginCollection();
        $shipmentStepHandler->add($shipmentPluginMock, CheckoutPageDependencyProvider::PLUGIN_SHIPMENT_STEP_HANDLER);
        $shipmentStep = $this->createShipmentStep($shipmentStepHandler);

        $shipmentBuilder = new ShipmentBuilder([ShipmentTransfer::SHIPMENT_SELECTION => CheckoutPageDependencyProvider::PLUGIN_SHIPMENT_STEP_HANDLER]);
        $quoteTransfer = (new QuoteBuilder())
            ->withItem((new ItemBuilder())->withShipment($shipmentBuilder))
            ->build();

        $shipmentStep->execute($this->createRequest(), $quoteTransfer);
    }

    /**
     * @return void
     */
    public function testShipmentPostConditionsShouldReturnTrueWhenShipmentSet()
    {
        $quoteTransfer = new QuoteTransfer();
        $expenseTransfer = new ExpenseTransfer();
        $expenseTransfer->setType(ShipmentConstants::SHIPMENT_EXPENSE_TYPE);
        $quoteTransfer->addExpense($expenseTransfer);

        $shipmentStep = $this->createShipmentStep(new StepHandlerPluginCollection());

        $this->assertTrue($shipmentStep->postCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testShipmentPostConditionsShouldReturnTrueWhenShipmentSetWithItemLevelShipments()
    {
        $shipmentTransfer = (new ShipmentBuilder([
            ShipmentTransfer::SHIPMENT_SELECTION => CheckoutPageDependencyProvider::PLUGIN_SHIPMENT_STEP_HANDLER,
        ]))->build();

        $quoteTransfer = (new QuoteBuilder())
            ->withExpense((new ExpenseBuilder([ExpenseTransfer::TYPE => ShipmentConstants::SHIPMENT_EXPENSE_TYPE])))
            ->withItem((new ItemBuilder()))
            ->build();

        $quoteTransfer->getItems()[0]->setShipment($shipmentTransfer);
        $quoteTransfer->getExpenses()[0]->setShipment($shipmentTransfer);

        $shipmentStep = $this->createShipmentStep(new StepHandlerPluginCollection());

        $this->assertTrue($shipmentStep->postCondition($quoteTransfer));
    }

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection $shipmentPlugins
     *
     * @return \SprykerShop\Yves\CheckoutPage\Process\Steps\ShipmentStep
     */
    protected function createShipmentStep(StepHandlerPluginCollection $shipmentPlugins)
    {
        return new ShipmentStep(
            $this->createCalculationClientMock(),
            $shipmentPlugins,
            $this->createPostConditionChecker(),
            'checkout-shipment',
            'home'
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequest()
    {
        return Request::createFromGlobals();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCalculationClientInterface
     */
    protected function createCalculationClientMock()
    {
        $calculationMock = $this->getMockBuilder(CheckoutPageToCalculationClientInterface::class)->getMock();
        $calculationMock->method('recalculate')->willReturnArgument(0);

        return $calculationMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\SprykerShop\Yves\CheckoutPage\Process\Steps\PostConditionCheckerInterface
     */
    protected function createPostConditionChecker()
    {
        return new PostConditionChecker(
            new CheckoutPageToShipmentServiceBridge($this->getLocator()->shipment()->service())
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface
     */
    protected function createShipmentMock()
    {
        return $this->getMockBuilder(StepHandlerPluginInterface::class)->getMock();
    }
}
