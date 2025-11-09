<?php

declare(strict_types=1);

namespace iamgerwin\Toon;

/**
 * Configuration options for TOON decoding.
 */
class DecodeOptions
{
    public function __construct(
        public bool $strict = true,
        public bool $associative = true,
        public int $depth = 512,
    ) {}

    /**
     * Create strict decoding options (validation enabled).
     */
    public static function strict(): self
    {
        return new self(strict: true);
    }

    /**
     * Create lenient decoding options (relaxed validation).
     */
    public static function lenient(): self
    {
        return new self(strict: false);
    }
}
