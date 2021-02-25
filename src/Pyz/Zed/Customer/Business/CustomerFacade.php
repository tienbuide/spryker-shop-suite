<?php


namespace Pyz\Zed\Customer\Business;

use Generated\Shared\Transfer\RpcArgumentTransfer;
use Generated\Shared\Transfer\RpcCallTransfer;
use Generated\Shared\Transfer\RpcTypeNullTransfer;
use Pyz\Client\Customer\CustomerZedRequest\CustomerZedRequestFactory;
use Spryker\Client\Kernel\Locator;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class CustomerFacade extends AbstractFacade
{
    public function __call($name, $arguments)
    {
        $argumentsCollection = new \ArrayObject();
        foreach ($arguments as $argument) {
            if (!is_object($argument)) {
                $rpcTransferClass = '\Generated\Shared\Transfer\RpcType' . ucfirst(gettype($argument)) . 'Transfer';
                $argument = (new $rpcTransferClass)->setValue($argument);
            }
            $rpcArgumentTransfer = (new RpcArgumentTransfer())
                ->setType(get_class($argument))
                ->setValue($argument);
            $argumentsCollection->append($rpcArgumentTransfer);
        }
        $transferObject = (new RpcCallTransfer())
            ->setMethod($name)
            ->setArguments($argumentsCollection);


        $return = $this->getPbcClient()->call('/customer/gateway/rpc', $transferObject);

        // workaround for Order expander plugin
        if ($name === 'hydrateSalesOrderCustomerInformation') {
            $orderTransfer = $arguments[0];
            $orderTransfer->fromArray($return->modifiedToArray());

            return $orderTransfer;
        }

        return $this->convertReturnObject($return);
    }

    /**
     * @rew
     */
    protected function getPbcClient()
    {
        // Hack: Zed uses zedRequest from Client
        /** @var \Spryker\Client\ZedRequest\ZedRequestClient $zedRequestClient */
        $zedRequestClient = Locator::getInstance()->zedRequest()->client();
        $zedRequestClient->setFactory(new CustomerZedRequestFactory());

        return $zedRequestClient;
    }

    protected function convertReturnObject($return)
    {
        if ($return instanceof RpcTypeNullTransfer) {
            return null;
        }

        return preg_match('/RpcType[A-Za-z]+Transfer/', get_class($return)) === 1 ? $return->getValue() : $return;
    }
}
