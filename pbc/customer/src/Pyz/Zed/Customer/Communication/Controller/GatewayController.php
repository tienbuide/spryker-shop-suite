<?php


namespace Pyz\Zed\Customer\Communication\Controller;

use Generated\Shared\Transfer\RpcArgumentTransfer;
use Generated\Shared\Transfer\RpcCallTransfer;
use Generated\Shared\Transfer\RpcTypeNullTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Zed\Customer\Communication\Controller\GatewayController as SprykerGatewayController;

class GatewayController extends SprykerGatewayController
{
    public function rpcAction(RpcCallTransfer $rpcCallTransfer)
    {
        $return = call_user_func_array(
            [$this->getFacade(), $rpcCallTransfer->getMethodOrFail()],
            $this->getArgumentsArray($rpcCallTransfer->getArguments())
        );

        if ($return instanceof AbstractTransfer) {
            return $return;
        }
        if (is_null($return)) {
            return new RpcTypeNullTransfer();
        }

        $transferName = '\Generated\Shared\Transfer\RpcType' . ucfirst(gettype($return)) . 'ResponseTransfer';

        return (new $transferName())->setValue($return);
    }

    /**
     * @param RpcArgumentTransfer[]|mixed|\ArrayObject $rpcArgumentTransfers
     *
     * @return mixed[]
     */
    protected function getArgumentsArray(\ArrayObject $rpcArgumentTransfers): array
    {
        $arguments = [];
        foreach ($rpcArgumentTransfers as $rpcArgumentTransfer) {
            $type = $rpcArgumentTransfer->getTypeOrFail();
            if (preg_match('/RpcType[A-Za-z]+Transfer/', $type) === 1) {
                $arguments[] = $rpcArgumentTransfer->getValue()['value'];
                continue;
            }

            $arguments[] = (new $type)->fromArray($rpcArgumentTransfer->getValue(), true);
        }

        return $arguments;
    }
}
