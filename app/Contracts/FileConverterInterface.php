<?php

namespace App\Contracts;

interface FileConverterInterface
{
    public function convert(array $jsonData): string;
}
