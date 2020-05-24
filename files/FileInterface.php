<?php

declare(strict_types=1);

namespace common\components\import\cvacs\files;

use Ds\Deque;

/**
 * Interface FileInterface
 * @package common\components\import\cvacs
 */
interface FileInterface
{
    public function __construct(string $filePath);

    public function getExt(): string;

    public function getFile(): \SplFileObject;

    public function readFileAsCsv(int $startLine = 1, string $delimiter = ','): Deque;

    public function move(string $pathTo): bool;

    public function delete(): bool;
}
