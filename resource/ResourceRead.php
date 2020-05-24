<?php

declare(strict_types=1);

namespace common\components\import\cvacs\resource;

/**
 * Class ResourceRead
 * @package common\components\import\cvacs\resource
 */
class ResourceRead
{
    private $resourcePath;
    private $files = [];

    /**
     * ResourceRead constructor.
     * @param string $resourcePath
     */
    private function __construct(string $resourcePath)
    {
        $this->resourcePath = $resourcePath;
        $this->readPath();
    }

    protected function readPath(): void
    {
        $this->files = array_diff(scandir($this->resourcePath), ['..', '.']);
    }

    /**
     * @param string $resourcePath
     * @return array
     */
    public static function read(string $resourcePath): array
    {
        return (new self($resourcePath))->files;
    }
}