<?php

declare(strict_types=1);

use iamgerwin\Toon\DecodeOptions;
use iamgerwin\Toon\EncodeOptions;
use iamgerwin\Toon\Toon;

if (! function_exists('toon')) {
    /**
     * Encode a value to TOON format.
     */
    function toon(mixed $value, ?EncodeOptions $options = null): string
    {
        return Toon::encode($value, $options);
    }
}

if (! function_exists('toon_decode')) {
    /**
     * Decode a TOON string to a PHP value.
     */
    function toon_decode(string $toon, ?DecodeOptions $options = null): mixed
    {
        return Toon::decode($toon, $options);
    }
}

if (! function_exists('toon_compact')) {
    /**
     * Encode to compact TOON format.
     */
    function toon_compact(mixed $value): string
    {
        return Toon::compact($value);
    }
}

if (! function_exists('toon_readable')) {
    /**
     * Encode to readable TOON format.
     */
    function toon_readable(mixed $value): string
    {
        return Toon::readable($value);
    }
}

if (! function_exists('toon_tabular')) {
    /**
     * Encode to tabular TOON format.
     */
    function toon_tabular(mixed $value): string
    {
        return Toon::tabular($value);
    }
}

if (! function_exists('toon_compare')) {
    /**
     * Compare TOON vs JSON token usage.
     *
     * @return array{toon: string, json: string, toon_tokens: int, json_tokens: int, savings_percent: float}
     */
    function toon_compare(mixed $value, ?EncodeOptions $options = null): array
    {
        return Toon::compare($value, $options);
    }
}

if (! function_exists('toon_estimate_tokens')) {
    /**
     * Estimate token count for a TOON string.
     */
    function toon_estimate_tokens(string $toon): int
    {
        return Toon::estimateTokens($toon);
    }
}
