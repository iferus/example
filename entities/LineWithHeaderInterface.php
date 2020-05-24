<?php

declare(strict_types=1);

namespace common\components\import\cvacs\entities;

/**
 * Interface LineWithHeaderInterface
 * @package common\components\import\cvacs\entities
 */
interface LineWithHeaderInterface
{
    /**
     * @return HeaderLine
     */
    public function getHeaderLine(): HeaderLine;
}
