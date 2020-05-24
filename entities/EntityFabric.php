<?php

declare(strict_types=1);

namespace common\components\import\cvacs\entities;

use common\components\import\cvacs\casts\InvalidCastParamException;
use Ds\Deque;

/**
 * Class EntityFabric
 * @package common\components\import\cvacs
 */
class EntityFabric
{
    /**
     * @param HeaderLine $headerLine
     * @param Deque $slice
     * @return EFTCardDetails|PosTransaction|TransactionItem|null
     * @throws InvalidCastParamException
     */
    public static function getEntityByVC(HeaderLine $headerLine, Deque $slice): ?AbstractEntity
    {
        $entity = null;
        switch ($headerLine->getType()) {
            case PosTransaction::NUMBER_LINE_HEADER:
                $entity = EntityVersionControlFabric::getEntityPosTransaction($headerLine, $slice);
                break;
            case TransactionItem::NUMBER_LINE_HEADER:
                $entity = EntityVersionControlFabric::getEntityTransactionItem($headerLine, $slice);
                break;
            case EFTCardDetails::NUMBER_LINE_HEADER:
                $entity = EntityVersionControlFabric::getEntityEFTCardDetails($headerLine, $slice);
                break;
        }

        return $entity;
    }
}
