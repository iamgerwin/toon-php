<?php

declare(strict_types=1);

namespace iamgerwin\Toon;

/**
 * Configuration options for TOON decoding.
 */
class DecodeOptions
{
    /** @var bool */
    public $strict;

    /** @var bool */
    public $associative;

    /** @var int */
    public $depth;

    public function __construct(
        bool $strict = true,
        bool $associative = true,
        int $depth = 512
    ) {
        $this->strict = $strict;
        $this->associative = $associative;
        $this->depth = $depth;
    }

    /**
     * Create strict decoding options (validation enabled).
     */
    public static function strict(): self
    {
        return new self(true);
    }

    /**
     * Create lenient decoding options (relaxed validation).
     */
    public static function lenient(): self
    {
        return new self(false);
    }
}
