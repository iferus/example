<?php

declare(strict_types=1);

namespace common\components\import\cvacs\services;

use common\components\import\cvacs\entities\EFTCardDetails;
use common\components\import\cvacs\entities\PosTransaction;
use common\components\import\cvacs\entities\TransactionItem;
use common\components\import\cvacs\repositories\AbstractRepository;
use common\components\import\cvacs\repositories\RepositoryVersionControlFabric;
use Ds\Queue;

/**
 * Class ImportService
 * @package common\components\import\cvacs
 */
class ImportService
{
    /**
     * @var array
     */
    protected $types = [
        TransactionItem::NUMBER_LINE_HEADER,
        PosTransaction::NUMBER_LINE_HEADER,
        EFTCardDetails::NUMBER_LINE_HEADER,
    ];

    /**
     * @var AbstractRepository[]
     */
    private $repositories;
    /**
     * @var Queue
     */
    private $allData;

    /**
     * ImportService constructor.
     * @param Queue $allData
     */
    public function __construct(Queue $allData)
    {
        $this->allData = $allData;
        $this->setRepositories();
    }

    /**
     * add worked Repository
     */
    protected function setRepositories(): void
    {
        $this->repositories = [];
        foreach ($this->types as $type) {
            $this->repositories[$type] = RepositoryVersionControlFabric::getRepositoryByTypeOperation($type);
        }
    }

    /**
     * add data lines to repositories $this->repositories by key line
     */
    public function saveData(): void
    {
        while (!$this->allData->isEmpty()) {
            $line = $this->allData->pop();
            if (isset($this->repositories[$line->getHeaderLine()->getType()])) {
                $this->repositories[$line->getHeaderLine()->getType()]->addArrData($line);
            }
        }

        $this->saveRepository();
    }

    /**
     * save request to DB
     */
    protected function saveRepository(): void
    {
        foreach ($this->repositories as $repository) {
            $repository->saveArr();
        }
    }
}
