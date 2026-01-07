<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;
use stdClass;

interface PhotoAnalyzerInterface
{
    public function analyze(UploadedFile $photo): array;
}
