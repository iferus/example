<?php

declare(strict_types=1);

namespace common\components\import\cvacs\repositories;

use common\components\clickhouse\Query;
use common\components\import\cvacs\entities\AbstractEntity;

/**
 * Class AbstractRepository
 * @package common\components\import\cvacs\repositories
 */
abstract class AbstractRepository
{
    protected $data;

    /**
     * @return string
     */
    abstract public function getTableName(): string;

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return [
            'processed',
            'type',
            'exportDateTime',
            'operation',
            'azs'
        ];
    }


    /**
     * @param AbstractEntity $entity
     * @return array
     */
    public function transform(AbstractEntity $entity): array
    {
        return [
            $entity->getHeaderLine()->getProcessed(),
            $entity->getHeaderLine()->getType(),
            $entity->getHeaderLine()->getExportDateTime()->format('Y-m-d H:i:s'),
            $entity->getHeaderLine()->getOperation(),
            $entity->getHeaderLine()->getAzs(),
        ];
    }

    /**
     * @param AbstractEntity $entity
     */
    public function addArrData(AbstractEntity $entity): void
    {
        $this->data[] = $this->transform($entity);
    }

    /**
     * @return int
     * @throws \yii\db\Exception
     */
    public function saveArr()
    {
        $query = new Query();
        $return = $query->createCommand()
            ->batchInsert($this->getTableName(), $this->getColumns(), $this->data)
            ->execute();
            
        \Yii::$app->clickhouse->close();

        return $return;
    }
}