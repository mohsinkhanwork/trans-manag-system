<?php
namespace App\Services;

use App\Contracts\TranslationExportInterface;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

class TranslationExportService implements TranslationExportInterface
{
    public function export(?string $locale = null): array
    {
        $cacheKey = $locale ? "translations.export.{$locale}" : "translations.export.all";
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function() use ($locale) {
            $query = $locale ? Translation::byLocale($locale) : Translation::query();
            
            $translations = [];
            
            $query->select('key', 'value')
                ->cursor()
                ->each(function ($translation) use (&$translations) {
                    $translations[$translation->key] = $translation->value;
                });
                
            return $translations;
        });
    }
}