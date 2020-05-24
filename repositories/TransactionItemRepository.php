<?php

declare(strict_types=1);

namespace common\components\import\cvacs\repositories;

use common\components\import\cvacs\entities\AbstractEntity;
use common\components\import\cvacs\entities\TransactionItem;

/**
 * Class TransactionItemRepository
 * @package common\components\import\cvacs\repositories
 */
class TransactionItemRepository extends AbstractRepository
{
    public function getTableName(): string
    {
        return 'TransactionItem';
    }

    /**
     * @param AbstractEntity|TransactionItem $entity
     * @return array
     */
    public function transform(AbstractEntity $entity): array
    {
        return array_merge(parent::transform($entity), [
            //$entity->getParams()
            //...
        ]);
    }

    public function getColumns(): array
    {
        return array_merge(parent::getColumns(), [

        ]);
    }
}
