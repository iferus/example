<?php

declare(strict_types=1);

namespace common\components\import\cvacs\casts;

use DateTime;
use Ds\Deque;
use Exception;

/**
 * Class HeaderLineCast
 * @package common\components\import\cvacs\casts
 */
class HeaderLineCast
{
    /**
     * Processed
     * @var $leadSign
     */
    private $processed;

    /**
     * Type
     * @var $numberLineHeader
     */
    private $type;

    /**
     * Date/time
     * @var $exportDateTime
     */
    private $exportDateTime;

    /**
     * Operation
     * @var $typeOperation
     */
    private $operation;

    /**
     * shell code
     * @var int $azs
     */
    private $azs;

    /**
     * HeaderLineCast constructor.
     * @param Deque $params
     * @param int $azs
     * @throws InvalidCastParamException
     */
    public function __construct(Deque $params, int $azs)
    {
        $this->checkParams($params, $azs);
        $this->setParams($params, $azs);
    }

    /**
     * @param Deque $params
     * @throws InvalidCastParamException
     */
    protected function checkParams(Deque $params): void
    {
        if ($params->count() !== 4) {
            throw new InvalidCastParamException('Config not enough parameters');
        }
    }

    /**
     * @param $params
     * @param int $azs
     * @throws Exception
     */
    protected function setParams($params, int $azs): void
    {
        [
            $setProcessed,
            $setType,
            $setExportDateTime,
            $setOperation
        ] = $params;

        $this->setAzs($azs);
        $this->setProcessed((int) $setProcessed);
        $this->setType((int) $setType);
        $this->setExportDateTime(new DateTime($setExportDateTime));
        $this->setOperation((int) $setOperation);
    }

    /**
     * @return mixed
     */
    public function getAzs(): int
    {
        return $this->azs;
    }

    /**
     * @param int $azs
     */
    public function setAzs(int $azs): void
    {
        $this->azs = $azs;
    }

    /**
     * @return mixed
     */
    public function getProcessed(): int
    {
        return $this->processed;
    }

    /**
     * @param int $processed
     */
    public function setProcessed(int $processed): void
    {
        $this->processed = $processed;
    }

    /**
     * @return mixed
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getExportDateTime(): DateTime
    {
        return $this->exportDateTime;
    }

    /**
     * @param DateTime $exportDateTime
     */
    public function setExportDateTime(DateTime $exportDateTime): void
    {
        $this->exportDateTime = $exportDateTime;
    }

    /**
     * @return mixed
     */
    public function getOperation(): int
    {
        return $this->operation;
    }

    /**
     * @param int $operation
     */
    public function setOperation(int $operation): void
    {
        $this->operation = $operation;
    }
}
