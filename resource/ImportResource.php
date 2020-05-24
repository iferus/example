<?php

declare(strict_types=1);

namespace common\components\import\cvacs\resource;

use common\components\import\cvacs\files\CvacsFile;
use common\components\import\cvacs\Import;
use common\components\import\queue\SendQueueImportRecords;
use common\models\RecordsColumn;
use Throwable;

/**
 * Class ImportResource
 * @package common\components\import\cvacs\resource
 */
class ImportResource
{
    public $scanDir;
    public $archiveDir;
    public $unzippingDir;

    public function __construct(string $scanDir, string $archiveDir)
    {
        $this->scanDir = $scanDir;
        $this->archiveDir = $archiveDir;
        $this->unzippingDir = $scanDir . 'unzipping/';
    }

    /**
     * @return $this
     * @throws Throwable
     */
    public function processUnzip(): self
    {
        if (!file_exists($this->unzippingDir)) {
            mkdir($this->unzippingDir, 0777);
        }

        if (!is_writable($this->unzippingDir)) {
            chmod($this->unzippingDir, 0777);
        }

        foreach ($this->scanDir($this->scanDir) as $file) {
            if (is_dir($this->scanDir . $file)) {
                continue;
            }

            $fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if ($fileExt !== 'zip') {
                continue;
            }

            UnzipFile::unzip($this->scanDir . $file, $this->unzippingDir);

            if (!is_writable($this->scanDir . $file)) {
                chmod($this->scanDir . $file, 0777);
            }

            unlink($this->scanDir . $file);
        }

        return $this;
    }

    /**
     * @param array $params
     */
    public function import(array $params): void
    {
        $fileList = $this->scanDir($this->unzippingDir);
        $total = count($fileList);
        $count = 0;

        $recordList = $this->getRecordColumns();

        foreach ($fileList as $file) {
            $count++;

            try {
                $cvacsFileObj = new CvacsFile($this->unzippingDir . $file);
                $import = new Import($cvacsFileObj);

                $import->setAllDataToDB()->saveData();
                echo "\t[{$count}/{$total}] - Импорт файла {$file} завершен" . PHP_EOL;

                $azs = $cvacsFileObj->getAzs();
                $date = $cvacsFileObj->getDateFile();

                $cvacsFileObj->move($this->archiveDir);

                $this->setQueueImport($recordList, $azs, $date, $params);
                echo PHP_EOL;
            } catch (Throwable $exception) {
                echo "\t[{$count}/{$total}] - Импорт файла {$file} завершен с ошибкой {$exception->getMessage()}" .
                        PHP_EOL . PHP_EOL;
            }
        }
    }

    /**
     * @param array $recordList
     * @param int $azs
     * @param \DateTime $dateImport
     * @param array $params
     */
    protected function setQueueImport(array $recordList, int $azs, \DateTime $dateImport, array $params): void
    {
        echo "\t\t send to QueueImport AZS: {$azs}, date: " . $dateImport->format('Y-m-d') . " " . PHP_EOL;

        $send = new SendQueueImportRecords();
        $send->setColumns($recordList);
        $send->setAzs($azs);
        $send->setPeriod($dateImport->format('Y-m-d'), $dateImport->format('Y-m-d'));
        $send->send($params['exchange'], $params['queue'], $params['routingKey']);
    }

    /**
     * @return array
     */
    protected function getRecordColumns(): array
    {
        $recordList = RecordsColumn::find()
            ->where(['LIKE', 'name', 'loyalty'])
            ->indexBy('name')
            ->asArray()
            ->all();

        return array_keys($recordList);
    }

    /**
     * @param string $dir
     * @return array
     */
    protected function scanDir(string $dir): array
    {
        return ResourceRead::read($dir);
    }
}
