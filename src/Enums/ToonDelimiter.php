<?php

declare(strict_types=1);

namespace iamgerwin\Toon\Enums;

/**
 * Delimiter options for TOON array encoding.
 */
enum ToonDelimiter: string
{
    case COMMA = ',';
    case TAB = "\t";
    case PIPE = '|';
}
