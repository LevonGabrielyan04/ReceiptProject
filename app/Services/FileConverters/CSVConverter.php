<?php

namespace App\Services\FileConverters;

use App\Contracts\FileConverterInterface;
use Illuminate\Support\Facades\Response;

class CSVConverter implements FileConverterInterface
{
    public function convert(array $jsonData): string
    {
        if (!isset($jsonData[0])) {
            $jsonData = [$jsonData];
        }

        $handle = fopen('php://temp', 'r+');

        if (!empty($jsonData)) {
            fputcsv($handle, array_keys($jsonData[0]));

            foreach ($jsonData as $row) {
                fputcsv($handle, $row);
            }
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

       return $csv;
    }
}
