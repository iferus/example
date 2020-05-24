<?php

declare(strict_types=1);

namespace common\components\import\cvacs\resource;

use common\components\import\cvacs\files\FileException;
use SplFileObject;
use ZipArchive;
use Throwable;

/**
 * Class UnzipFile
 * @package common\components\import\cvacs\resource
 */
class UnzipFile
{
    /**
     * @var SplFileObject
     */
    private $file;
    private $to;

    /**
     * UnzipFile constructor.
     * @param string $zipPath
     * @param string $to
     * @throws FileException
     */
    private function __construct(string $zipPath, string $to)
    {
        $this->file = new SplFileObject($zipPath);
        $this->checkZipFile();
        $this->to = $to;
        $this->checkUnZipFolder();
    }

    /**
     * @throws FileException
     */
    private function checkUnZipFolder(): void
    {
        if (!is_dir($this->to)) {
            throw new FileException("Path {$this->to} is not directory");
        }
    }

    /**
     * @throws FileException
     */
    private function checkZipFile(): void
    {
        $ext = $this->file->getExtension();
        if ($ext !== 'zip') {
            throw new FileException("File {$this->file->getFilename()} must be 'zip' extension");
        }
    }

    /**
     * @throws FileException
     */
    private function process(): void
    {
        $zip = new ZipArchive();
        $zip->open($this->file->getPathname());

        if (!$zip->extractTo($this->to)) {
            throw new FileException("failed to extract archive {{$this->file->getFilename()}}");
        }

        $zip->close();
    }

    /**
     * @param string $zipPath
     * @param string $to
     * @return bool
     * @throws Throwable
     */
    public static function unzip(string $zipPath, string $to)
    {
        try {
            $p = new self($zipPath, $to);
            $p->process();
            return true;
        } catch (Throwable $exception) {
            throw $exception;
        }
    }
}