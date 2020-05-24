<?php

declare(strict_types=1);

namespace common\components\import\cvacs\entities;

use common\components\import\cvacs\builders\EFTCardDetailsBuilder;
use common\components\import\cvacs\builders\PosTransactionBuilder;
use common\components\import\cvacs\builders\TransactionItemBuilder;
use common\components\import\cvacs\casts\EFTCardDetailsCast;
use common\components\import\cvacs\casts\PosTransactionCast;
use common\components\import\cvacs\casts\TransactionItemCast;
use common\components\import\cvacs\casts\InvalidCastParamException;
use Ds\Deque;

/**
 * Class VersionControlHelper
 * @package common\components\import\cvacs
 */
class EntityVersionControlFabric
{
    protected function setVersionsChainPosTransaction(): void
    {
        //TODO add versions
    }

    /**
     * @param HeaderLine $headerLine
     * @param Deque $slice
     * @return PosTransaction
     * @throws InvalidCastParamException
     */
    public static function getEntityPosTransaction(HeaderLine $headerLine, Deque $slice): PosTransaction
    {
        return PosTransactionBuilder::getEntityByCast($headerLine, new PosTransactionCast($slice));
    }

    protected function setVersionsChainTransactionItem(): void
    {
        //TODO add versions
    }

    /**
     * @param HeaderLine $headerLine
     * @param Deque $slice
     * @return TransactionItem
     * @throws InvalidCastParamException
     */
    public static function getEntityTransactionItem(HeaderLine $headerLine, Deque $slice): TransactionItem
    {
        return TransactionItemBuilder::getEntityByCast($headerLine, new TransactionItemCast($slice));
    }

    protected function setVersionsChainEFTCardDetails(): void
    {
        //TODO add versions
    }

    /**
     * @param HeaderLine $headerLine
     * @param Deque $slice
     * @return EFTCardDetails
     * @throws InvalidCastParamException
     */
    public static function getEntityEFTCardDetails(HeaderLine $headerLine, Deque $slice): EFTCardDetails
    {
        return EFTCardDetailsBuilder::getEntityByCast($headerLine, new EFTCardDetailsCast($slice));
    }
}