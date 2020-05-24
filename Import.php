<?php

declare(strict_types=1);

namespace common\components\import\cvacs;

use common\components\import\cvacs\builders\HeaderLineBuilder;
use common\components\import\cvacs\casts\HeaderLineCast;
use common\components\import\cvacs\entities\AbstractEntity;
use common\components\import\cvacs\entities\EFTCardDetails;
use common\components\import\cvacs\entities\EntityFabric;
use common\components\import\cvacs\entities\HeaderLine;
use common\components\import\cvacs\entities\PosTransaction;
use common\components\import\cvacs\entities\TransactionItem;
use common\components\import\cvacs\files\CvacsFile;
use common\components\import\cvacs\files\FileInterface;
use common\components\import\cvacs\services\ImportService;
use Ds\Queue;
use Exception;
use Ds\Deque;

/**
 * Class Import
 * @package common\components\import\cvacs
 */
class Import
{
    /**
     * @var Queue
     */
    public $allData;

    /**
     * @var FileInterface
     */
    private $file;

    /**
     * ImportService constructor.
     * @param FileInterface|CvacsFile $file
     * @throws Exception
     */
    public function __construct(FileInterface $file)
    {
        $this->file = $file;
        $this->allData = new Queue();
    }

    /**
     * @return Deque
     * @throws files\FileException
     */
    protected function readFile(): Deque
    {
        return $this->file->readFileAsCSV();
    }

    /**
     * @return Import
     * @throws casts\InvalidCastParamException
     * @throws files\FileException
     */
    public function setAllDataToDB(): Import
    {
        $fileData = $this->readFile();

        while (!$fileData->isEmpty()) {
            $line = $fileData->shift();

            if ($line->get(0) === '') {
                continue;
            }

            $this->setQueueForDb($this->getLineObj($line));
        }

        return $this;
    }

    /**
     *
     */
    public function saveData(): void
    {
        (new ImportService($this->allData))->saveData();
    }

    /**
     * @param Deque $line
     * @return EFTCardDetails|PosTransaction|TransactionItem|null
     * @throws casts\InvalidCastParamException
     * @throws Exception
     */
    protected function getLineObj(Deque $line): ?AbstractEntity
    {
        return EntityFabric::getEntityByVC(
            $this->getHeaderLine($line),
            $line->slice(4, $line->count() - 1)
        );
    }

    /**
     * @param Deque $line
     * @return HeaderLine
     * @throws Exception
     */
    protected function getHeaderLine(Deque $line): HeaderLine
    {
        return HeaderLineBuilder::getEntityByCast(new HeaderLineCast($line->slice(0, 4), $this->file->getAzs()));
    }

    /**
     * @param AbstractEntity|null $abstractEntity
     */
    protected function setQueueForDb(?AbstractEntity $abstractEntity): void
    {
        if ($abstractEntity !== null) {
            $this->allData->push($abstractEntity);
        }
    }
}
