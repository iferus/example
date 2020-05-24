<?php

declare(strict_types=1);

namespace common\components\import\cvacs\casts;

use Ds\Deque;
use Exception;

/**
 * Class TransactionItemCast
 * @package common\components\import\cvacs\casts
 */
class TransactionItemCast
{

    /**
     * PosTransactionCast constructor.
     * @param Deque $params
     * @throws InvalidCastParamException
     * @throws Exception
     */
    public function __construct(Deque $params)
    {
        $this->checkParams($params);
        $this->setParams($params);
    }

    /**
     * @param Deque $params
     * @throws InvalidCastParamException
     */
    protected function checkParams(Deque $params): void
    {
        if ($params->count() < 14) {
            throw new InvalidCastParamException('Config not enough parameters');
        }
    }

    /**
     * @param $params
     * @throws Exception
     */
    protected function setParams($params): void
    {

    }


}
