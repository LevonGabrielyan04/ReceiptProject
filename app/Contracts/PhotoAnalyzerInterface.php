<?php

namespace App\Contracts;

interface PhotoAnalyzerInterface
{
    public function analyze($photo): string;
}
