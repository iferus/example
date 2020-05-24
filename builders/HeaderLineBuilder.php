<?php

declare(strict_types=1);

namespace common\components\import\cvacs\builders;

use common\components\import\cvacs\casts\HeaderLineCast;
use common\components\import\cvacs\entities\HeaderLine;
use DateTime;

/**
 * Class HeaderLineBuilder
 * @package common\components\import\cvacs\builders
 */
class HeaderLineBuilder
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
     * HeaderLineBuilder constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return HeaderLine
     */
    public function build(): HeaderLine
    {
        return new HeaderLine($this);
    }

    public static function getEntityByCast(HeaderLineCast $cast): HeaderLine
    {
        $build = new self();

        $build->addAzs($cast->getAzs())->addProcessed($cast->getProcessed())
            ->addType($cast->getType())
            ->addExportDateTime($cast->getExportDateTime())
            ->addOperation($cast->getOperation());

        return new HeaderLine($build);
    }

    /**
     * @return int
     */
    public function getAzs(): int
    {
        return $this->azs;
    }


    /**
     * @param int $azs
     * @return HeaderLineBuilder
     */
    public function addAzs(int $azs): HeaderLineBuilder
    {
        $this->azs = $azs;

        return $this;
    }

    /**
     * @return int
     */
    public function getProcessed(): int
    {
        return $this->processed;
    }

    /**
     * @param int $processed
     * @return HeaderLineBuilder
     */
    public function addProcessed(int $processed): HeaderLineBuilder
    {
        $this->processed = $processed;

        return $this;
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
     * @return HeaderLineBuilder
     */
    public function addType(int $type): HeaderLineBuilder
    {
        $this->type = $type;

        return $this;
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
     * @return HeaderLineBuilder
     */
    public function addExportDateTime(DateTime $exportDateTime): HeaderLineBuilder
    {
        $this->exportDateTime = $exportDateTime;

        return $this;
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
     * @return HeaderLineBuilder
     */
    public function addOperation(int $operation): HeaderLineBuilder
    {
        $this->operation = $operation;

        return $this;
    }
}
