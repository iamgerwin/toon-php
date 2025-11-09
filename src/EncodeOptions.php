<?php

declare(strict_types=1);

namespace iamgerwin\Toon;

use iamgerwin\Toon\Enums\ToonDelimiter;

/**
 * Configuration options for TOON encoding.
 */
class EncodeOptions
{
    public function __construct(
        public int $indent = 2,
        public ToonDelimiter $delimiter = ToonDelimiter::COMMA,
        public bool $useLengthMarker = true,
        public bool $preferTabular = true,
        public bool $quoteStrings = false,
        public bool $sortKeys = false,
    ) {}

    /**
     * Create compact encoding options (minimal whitespace).
     */
    public static function compact(): self
    {
        return new self(
            indent: 0,
            preferTabular: false,
            useLengthMarker: false,
        );
    }

    /**
     * Create readable encoding options (more whitespace).
     */
    public static function readable(): self
    {
        return new self(
            indent: 4,
            preferTabular: false,
        );
    }

    /**
     * Create tabular encoding options (optimized for uniform arrays).
     */
    public static function tabular(): self
    {
        return new self(
            indent: 2,
            preferTabular: true,
            useLengthMarker: true,
        );
    }
}
