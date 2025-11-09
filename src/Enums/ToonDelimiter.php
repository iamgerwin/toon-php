<?php

declare(strict_types=1);

namespace iamgerwin\Toon\Enums;

/**
 * Delimiter options for TOON array encoding.
 */
class ToonDelimiter
{
    public const COMMA = ',';
    public const TAB = "\t";
    public const PIPE = '|';

    /**
     * Get the default delimiter.
     */
    public static function default(): string
    {
        return self::COMMA;
    }

    /**
     * Validate if a delimiter is supported.
     */
    public static function isValid(string $delimiter): bool
    {
        return in_array($delimiter, [self::COMMA, self::TAB, self::PIPE], true);
    }
}
