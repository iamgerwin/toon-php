<?php

declare(strict_types=1);

namespace iamgerwin\Toon;

use iamgerwin\Toon\Exceptions\ToonException;

/**
 * Main TOON (Token-Oriented Object Notation) facade class.
 *
 * TOON is a compact data format designed to reduce token consumption
 * when sending structured data to Large Language Models, achieving
 * 30-60% token savings compared to JSON.
 */
class Toon
{
    /**
     * Encode a value to TOON format.
     *
     * @param  mixed  $value  The value to encode
     * @param  EncodeOptions|null  $options  Encoding options
     * @return string The TOON-encoded string
     *
     * @throws ToonException
     */
    public static function encode(mixed $value, ?EncodeOptions $options = null): string
    {
        $options ??= new EncodeOptions;

        return ToonSerializer::serialize($value, $options);
    }

    /**
     * Decode a TOON string to a PHP value.
     *
     * @param  string  $toon  The TOON string to decode
     * @param  DecodeOptions|null  $options  Decoding options
     * @return mixed The decoded value
     *
     * @throws ToonException
     */
    public static function decode(string $toon, ?DecodeOptions $options = null): mixed
    {
        $options ??= new DecodeOptions;

        return ToonDeserializer::deserialize($toon, $options);
    }

    /**
     * Encode to compact TOON format (minimal whitespace).
     */
    public static function compact(mixed $value): string
    {
        return self::encode($value, EncodeOptions::compact());
    }

    /**
     * Encode to readable TOON format (more whitespace for readability).
     */
    public static function readable(mixed $value): string
    {
        return self::encode($value, EncodeOptions::readable());
    }

    /**
     * Encode to tabular TOON format (optimized for uniform arrays).
     */
    public static function tabular(mixed $value): string
    {
        return self::encode($value, EncodeOptions::tabular());
    }

    /**
     * Estimate token count for a TOON string.
     *
     * This is a rough approximation using the common rule of thumb:
     * 1 token ≈ 4 characters for English text.
     */
    public static function estimateTokens(string $toon): int
    {
        return (int) ceil(strlen($toon) / 4);
    }

    /**
     * Compare TOON vs JSON token usage.
     *
     * @return array{toon: string, json: string, toon_tokens: int, json_tokens: int, savings_percent: float}
     */
    public static function compare(mixed $value, ?EncodeOptions $options = null): array
    {
        $toon = self::encode($value, $options);
        $json = json_encode($value, JSON_THROW_ON_ERROR);

        $toonTokens = self::estimateTokens($toon);
        $jsonTokens = self::estimateTokens($json);

        $savingsPercent = $jsonTokens > 0
            ? round((($jsonTokens - $toonTokens) / $jsonTokens) * 100, 2)
            : 0.0;

        return [
            'toon' => $toon,
            'json' => $json,
            'toon_tokens' => $toonTokens,
            'json_tokens' => $jsonTokens,
            'savings_percent' => $savingsPercent,
        ];
    }
}
