<?php

declare(strict_types=1);

namespace common\components\import\cvacs\repositories;

use common\components\import\cvacs\entities\EFTCardDetails;
use common\components\import\cvacs\entities\PosTransaction;
use common\components\import\cvacs\entities\TransactionItem;

/**
 * Class RepositoryVersionControlFabric
 * @package common\components\import\cvacs
 */
class RepositoryVersionControlFabric
{

    /**
     * @param int $type
     * @return AbstractRepository|null
     */
    public static function getRepositoryByTypeOperation(int $type): ?AbstractRepository
    {
        $fabric = new self();
        switch ($type) {
            case PosTransaction::NUMBER_LINE_HEADER:
                return $fabric->getPosTransactionRepository();

            case TransactionItem::NUMBER_LINE_HEADER:
                return $fabric->getTransactionItemRepository();

            case EFTCardDetails::NUMBER_LINE_HEADER:
                return $fabric->getEFTCardDetailsRepository();

            default:
                return null;
        }
    }

    /**
     * @return PosTransactionRepository
     */
    public function getPosTransactionRepository(): PosTransactionRepository
    {
        return new PosTransactionRepository();
    }

    /**
     * @return TransactionItemRepository
     */
    public function getTransactionItemRepository(): TransactionItemRepository
    {
        return new TransactionItemRepository();
    }

    /**
     * @return EFTCardDetailsRepository
     */
    public function getEFTCardDetailsRepository(): EFTCardDetailsRepository
    {
        return new EFTCardDetailsRepository();
    }
}