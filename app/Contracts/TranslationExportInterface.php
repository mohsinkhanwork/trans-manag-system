<?php

namespace App\Contracts;

interface TranslationExportInterface
{
    public function export(?string $locale = null): array;
}