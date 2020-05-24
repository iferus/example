<?php

declare(strict_types=1);

namespace common\components\import\cvacs\files;

use Ds\Deque;
use SplFileObject;

/**
 * Class FileAbstract
 * @package common\components\import\cvacs
 */
abstract class FileAbstract extends SplFileObject implements FileInterface
{
    abstract public function setParamsByFilename(): void;
    /**
     * FileAbstract constructor.
     * @param string $filePath
     * @throws FileException
     */
    public function __construct(string $filePath)
    {
        parent::__construct($filePath);
        $this->checkFile();
        $this->setParamsByFilename();
    }

    /**
     * @throws FileException
     */
    protected function checkFile()
    {
        if ($this->isDir()) {
            throw new FileException("{$this->getFile()->getFilename()} is directory");
        }

//        if (!$this->isWritable()) {
//            throw new FileException("{$this->getFile()->getFilename()} is not writable");
//        }
    }

    /**
     * @return string
     */
    public function getExt(): string
    {
        return $this->getExtension();
    }

    /**
     * @return SplFileObject
     */
    public function getFile(): SplFileObject
    {
        return $this;
    }

    /**
     * @param int $startLine
     * @param string $delimiter
     * @return Deque
     * @throws FileException
     */
    public function readFileAsCsv(int $startLine = 1, string $delimiter = ','): Deque
    {
        return CsvFileReader::readFile($this, $startLine, $delimiter);
    }

    /**
     * @param string $pathTo
     * @return bool
     */
    public function move(string $pathTo): bool
    {
        return rename($this->getFile()->getPathname(), $pathTo . $this->getFilename());
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return unlink($this->getFile()->getPathname());
    }
}
