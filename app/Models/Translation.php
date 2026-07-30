<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = ['key', 'en', 'km'];

    /**
     * Get a flat array of translations for a specific locale.
     * Falls back to English if the translation is empty, and to the key itself if English is empty.
     */
    public static function getTranslationsForLocale(string $locale): array
    {
        $translations = self::all();
        $map = [];

        foreach ($translations as $t) {
            $key = $t->key;
            $val = $t->$locale;

            // Fallback strategy: Active Locale -> English -> Key itself
            if (empty($val)) {
                $val = $t->en ?: $key;
            }

            $map[$key] = $val;
        }

        return $map;
    }
}
