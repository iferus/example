<?php

declare(strict_types=1);

namespace common\components\import\cvacs\repositories;

use common\components\import\cvacs\entities\AbstractEntity;
use common\components\import\cvacs\entities\EFTCardDetails;

/**
 * Class EFTCardDetailsRepository
 * @package common\components\import\cvacs\repositories
 */
class EFTCardDetailsRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'EFTCardDetails';
    }

    /**
     * @param AbstractEntity|EFTCardDetails $entity
     * @return array
     */
    public function transform(AbstractEntity $entity): array
    {
        return array_merge(parent::transform($entity), [
            //$entity->getParams()
            //...
        ]);
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return array_merge(parent::getColumns(), [

        ]);
    }
}