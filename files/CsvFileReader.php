<?php

declare(strict_types=1);

namespace common\components\import\cvacs\files;

use Ds\Deque;
use SplFileObject;

/**
 * Class CsvFileReader
 * @package common\components\import\cvacs
 */
class CsvFileReader
{
    /**
     * fileInfo
     *
     * @var SplFileObject
     */
    private $file;

    /**
     * param for set start line by read file
     * @var integer $startLine
     */
    private $startLine;

    /**
     * delimiter in csv files
     * @var string $delimiter
     */
    private $delimiter;

    /**
     * CsvFileReader constructor.
     * @param SplFileObject $fileObject
     * @param int $startLine
     * @param string $delimiter
     * @throws FileException
     */
    protected function __construct(SplFileObject $fileObject, int $startLine, string $delimiter)
    {
        $this->setOptions($fileObject, $startLine, $delimiter);
    }

    /**
     * @param SplFileObject $fileObject
     * @param int $startLine
     * @param string $delimiter
     * @return Deque
     * @throws FileException
     */
    public static function readFile(SplFileObject $fileObject, int $startLine = 1, string $delimiter = ','): Deque
    {
        $reader = new self($fileObject, $startLine, $delimiter);

        return $reader->getCollection();
    }

    /**
     * @param SplFileObject $fileObject
     * @param int $startLine
     * @param string $delimiter
     * @throws FileException
     */
    protected function setOptions(SplFileObject $fileObject, int $startLine, string $delimiter): void
    {
        if ($this->checkParams($fileObject, $startLine, $delimiter)) {
            $this->file = $fileObject;
            $this->startLine = $startLine;
            $this->delimiter = $delimiter;
        }
    }

    /**
     * @return Deque
     */
    protected function getCollection(): Deque
    {
        return $this->readProcess();
    }

    /**
     * @param SplFileObject $fileObject
     * @param int $startLine
     * @param string $delimiter
     * @return bool
     * @throws FileException
     */
    protected function checkParams(SplFileObject $fileObject, int $startLine, string $delimiter): bool
    {
        if (!$fileObject->isReadable()) {
            throw new FileException('File is not readable');
        }

        $ext = $fileObject->getExtension();
        if ($ext !== 'txt' && $ext !== "csv") {
            throw new FileException("File {$fileObject->getFilename()} must be 'txt' or 'csv' extension");
        }

        if ($startLine < 0) {
            throw new FileException('Param start line must be > 0');
        }

        if ($delimiter !== ',' && $delimiter !== ';') {
            throw new FileException('Param delimiter must , or ;');
        }

        return true;
    }

    /**
     * @return Deque
     */
    protected function readProcess(): Deque
    {
        $queue = new Deque();
        $line = 1;

        while (!$this->file->eof()) {
            $line++;

            $lineData = $this->file->fgetcsv($this->delimiter);

            if ($this->startLine >= $line) {
                continue;
            }

            $queue->push($this->lineFormat($lineData));
        }

        return $queue;
    }

    /**
     * @param array $data
     * @return Deque
     */
    protected function lineFormat(array $data): Deque
    {
        $queue = new Deque();
        $queue->allocate(count($data));

        foreach ($data as $str) {
            $queue->push($this->getUtfString(trim((string) $str)));
        }

        return $queue;
    }

    /**
     * @param string $str
     * @return string
     */
    protected function getUtfString(string $str): string
    {
        return iconv('CP1251', 'UTF-8', $str);
    }
}
