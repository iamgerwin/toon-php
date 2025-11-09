<?php

declare(strict_types=1);

namespace iamgerwin\Toon;

use iamgerwin\Toon\Enums\ToonDelimiter;

/**
 * Configuration options for TOON encoding.
 */
class EncodeOptions
{
    /** @var int */
    public $indent;

    /** @var string */
    public $delimiter;

    /** @var bool */
    public $useLengthMarker;

    /** @var bool */
    public $preferTabular;

    /** @var bool */
    public $quoteStrings;

    /** @var bool */
    public $sortKeys;

    public function __construct(
        int $indent = 2,
        string $delimiter = ToonDelimiter::COMMA,
        bool $useLengthMarker = true,
        bool $preferTabular = true,
        bool $quoteStrings = false,
        bool $sortKeys = false
    ) {
        $this->indent = $indent;
        $this->delimiter = $delimiter;
        $this->useLengthMarker = $useLengthMarker;
        $this->preferTabular = $preferTabular;
        $this->quoteStrings = $quoteStrings;
        $this->sortKeys = $sortKeys;
    }

    /**
     * Create compact encoding options (minimal whitespace).
     */
    public static function compact(): self
    {
        return new self(
            0,
            ToonDelimiter::COMMA,
            false,
            false
        );
    }

    /**
     * Create readable encoding options (more whitespace).
     */
    public static function readable(): self
    {
        return new self(
            4,
            ToonDelimiter::COMMA,
            true,
            false
        );
    }

    /**
     * Create tabular encoding options (optimized for uniform arrays).
     */
    public static function tabular(): self
    {
        return new self(
            2,
            ToonDelimiter::COMMA,
            true,
            true
        );
    }
}
