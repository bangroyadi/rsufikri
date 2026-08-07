<?php

namespace App\Traits;

trait HasTranslations
{
    /**
     * Get translation for a JSON field based on current locale or fallback
     * 
     * @param string $field
     * @param string|null $locale
     * @return string
     */
    public function tr(string $field, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->{$field} ?? [];

        if (is_string($value)) {
            // If already stored as plain string or JSON encoded string
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $value = $decoded;
            } else {
                return $value;
            }
        }

        if (is_array($value)) {
            if (isset($value[$locale]) && !empty($value[$locale])) {
                return $value[$locale];
            }
            if (isset($value['id']) && !empty($value['id'])) {
                return $value['id'];
            }
            if (isset($value['en']) && !empty($value['en'])) {
                return $value['en'];
            }
            return reset($value) ?: '';
        }

        return (string) $value;
    }
}
