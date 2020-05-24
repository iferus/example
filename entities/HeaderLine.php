<?php

declare(strict_types=1);

namespace common\components\import\cvacs\entities;

use common\components\import\cvacs\builders\HeaderLineBuilder;
use DateTime;

/**
 * Class HeaderLine
 * @package common\components\import\cvacs\entities
 */
class HeaderLine
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
     * HeaderLine constructor.
     * @param HeaderLineBuilder $builder
     */
    public function __construct(HeaderLineBuilder $builder)
    {
        $this->processed = $builder->getProcessed();
        $this->type = $builder->getType();
        $this->exportDateTime = $builder->getExportDateTime();
        $this->operation = $builder->getOperation();
        $this->azs = $builder->getAzs();
    }

    /**
     * @return int
     */
    public function getProcessed(): int
    {
        return $this->processed;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return DateTime
     */
    public function getExportDateTime(): DateTime
    {
        return $this->exportDateTime;
    }

    /**
     * @return int
     */
    public function getOperation(): int
    {
        return $this->operation;
    }

    /**
     * @return int
     */
    public function getAzs(): int
    {
        return $this->azs;
    }
}
