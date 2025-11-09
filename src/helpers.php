<?php

declare(strict_types=1);

use iamgerwin\Toon\DecodeOptions;
use iamgerwin\Toon\EncodeOptions;
use iamgerwin\Toon\Toon;

if (! function_exists('toon')) {
    /**
     * Encode a value to TOON format.
     *
     * @param mixed $value
     * @param EncodeOptions|null $options
     * @return string
     */
    function toon($value, $options = null): string
    {
        return Toon::encode($value, $options);
    }
}

if (! function_exists('toon_decode')) {
    /**
     * Decode a TOON string to a PHP value.
     *
     * @param string $toon
     * @param DecodeOptions|null $options
     * @return mixed
     */
    function toon_decode(string $toon, $options = null)
    {
        return Toon::decode($toon, $options);
    }
}

if (! function_exists('toon_compact')) {
    /**
     * Encode to compact TOON format.
     *
     * @param mixed $value
     * @return string
     */
    function toon_compact($value): string
    {
        return Toon::compact($value);
    }
}

if (! function_exists('toon_readable')) {
    /**
     * Encode to readable TOON format.
     *
     * @param mixed $value
     * @return string
     */
    function toon_readable($value): string
    {
        return Toon::readable($value);
    }
}

if (! function_exists('toon_tabular')) {
    /**
     * Encode to tabular TOON format.
     *
     * @param mixed $value
     * @return string
     */
    function toon_tabular($value): string
    {
        return Toon::tabular($value);
    }
}

if (! function_exists('toon_compare')) {
    /**
     * Compare TOON vs JSON token usage.
     *
     * @param mixed $value
     * @param EncodeOptions|null $options
     * @return array<string, mixed> Array with keys: toon, json, toon_tokens, json_tokens, savings_percent
     */
    function toon_compare($value, $options = null): array
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
