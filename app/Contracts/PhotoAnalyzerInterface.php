<?php

namespace App\Contracts;

use stdClass;

interface PhotoAnalyzerInterface
{
    public function analyze($photo): stdClass;
}
