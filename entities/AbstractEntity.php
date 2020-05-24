<?php

declare(strict_types=1);

namespace common\components\import\cvacs\entities;

/**
 * Class AbstractEntity
 * @package common\components\import\cvacs\entities
 */
abstract class AbstractEntity implements LineWithHeaderInterface
{
    protected $headerLine;
    /**
     * @return HeaderLine
     */
    public function getHeaderLine(): HeaderLine
    {
        return $this->headerLine;
    }
}
