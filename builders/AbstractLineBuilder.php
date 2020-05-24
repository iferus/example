<?php

declare(strict_types=1);

namespace common\components\import\cvacs\builders;

use common\components\import\cvacs\entities\HeaderLine;

/**
 * Class AbstractLineBuilder
 * @package common\components\import\cvacs\builders
 */
abstract class AbstractLineBuilder
{
    /**
     * @var HeaderLine
     */
    public $headerLine;

    /**
     * @return mixed
     */
    public function getHeaderLine(): HeaderLine
    {
        return $this->headerLine;
    }

    /**
     * @param HeaderLine $headerLine
     * @return $this
     */
    public function addHeaderLine(HeaderLine $headerLine): AbstractLineBuilder
    {
        $this->headerLine = $headerLine;

        return $this;
    }
}
