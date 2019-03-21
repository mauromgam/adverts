<?php

namespace App\Traits;

use League\Csv\Reader;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Trait CsvHelpersTrait
 *
 * @package App\Traits
 */
trait CsvHelpersTrait
{
    /**
     * @var array
     */
    protected $csvFileExtension = [
        'csv', 'txt'
    ];

    /**
     * @param int $fileSize
     * @throws \Exception
     */
    protected function assertFileSize(int $fileSize):void
    {
        $sizeLimit = env('FILE_SIZE');
        if ($fileSize > $sizeLimit) {
            throw new \Exception(sprintf('File exceed the file size limit (%s)', $sizeLimit));
        }
    }

    /**
     * @param string $extension
     * @throws \Exception
     */
    protected function assertExtension(string $extension):void
    {
        if (!in_array($extension, $this->csvFileExtension)) {
            throw new \Exception('File type not supported');
        }
    }

    /**
     * @param Reader $csv
     * @param int $maxRows
     * @throws \Exception
     */
    protected function assertCount(Reader $csv, int $maxRows = 500):void
    {
        if ($csv->count() > $maxRows) {
            throw new \Exception('Exceed maximum rows: '. $maxRows);
        }
    }

    /**
     * @param Reader $csv
     * @param string $delimiter
     * @throws \Exception
     */
    protected function assertDelimiter(Reader $csv, $delimiter = ','):void
    {
        if ($csv->getDelimiter() != $delimiter) {
            throw new \Exception(sprintf("Delimiter should be '%s' ", $delimiter));
        }
    }

    /**
     * @param Reader $csv
     * @param array $header
     * @throws \Exception
     */
    protected function assertHeader(Reader $csv, array $header):void
    {
        if ($header != $csv->getHeader()) {
            $diffExtra   = '[' . implode(', ', array_diff($csv->getHeader(), $header)) . ']';
            $diffMissing = '[' . implode(', ', array_diff($header, $csv->getHeader())) . ']';
            throw new \Exception(
                sprintf(
                    'Column header did not match. Extra fields provided: %s. Fields missing: %s',
                    $diffExtra,
                    $diffMissing
                )
            );
        }
    }

    /**
     * Parse CSV file from request
     *
     * @param $fileName
     * @param $relativePath
     * @param $header
     * @param int $rowCount
     * @return Reader
     * @throws \League\Csv\Exception
     * @throws \Exception
     */
    public function parseCSVFile($fileName, $relativePath, $header, $rowCount = 500):Reader
    {
        if (!file_exists($relativePath . '/' . $fileName)) {
            throw new \Exception('File is not valid');
        }

        $info = new SplFileInfo($fileName, $relativePath, $relativePath);
        $this->assertFileSize(filesize("$relativePath/$fileName"));
        $this->assertExtension($info->getExtension());

        $csv = Reader::createFromPath($relativePath . '/' . $fileName, 'r');
        $csv->setOutputBOM(Reader::BOM_UTF8);
        $this->assertCount($csv, $rowCount);
        $this->assertDelimiter($csv);

        $csv->setHeaderOffset(0);
        $this->assertHeader($csv, $header);

        return $csv;
    }
}
