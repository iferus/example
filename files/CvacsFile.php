<?php

declare(strict_types=1);

namespace common\components\import\cvacs\files;

use DateTime;
use Exception;

/**
 * Class CvacsFile
 * @package common\components\import\cvacs
 */
class CvacsFile extends FileAbstract
{
    /**
     * @var int
     */
    private $azs;

    /**
     * @var DateTime
     */
    private $dateFile;

    /**
     * @throws Exception
     */
    public function setParamsByFilename(): void
    {
        $fileName = $this->getFilename();
        $params = $this->getParams($fileName);
        $this->azs = (int) array_shift($params);
        $this->dateFile = new DateTime(array_shift($params));
    }

    /**
     * @param string $fileName
     * @return array
     */
    protected function getParams(string $fileName): array
    {
        return preg_split('/[\D]/', $fileName, 0, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @return int
     */
    public function getAzs(): int
    {
        return $this->azs;
    }

    /**
     * @return DateTime
     */
    public function getDateFile(): DateTime
    {
        return $this->dateFile;
    }


}
