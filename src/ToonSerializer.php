<?php

declare(strict_types=1);

namespace iamgerwin\Toon;

use BackedEnum;
use DateTime;
use DateTimeInterface;
use iamgerwin\Toon\Exceptions\EncodingException;
use UnitEnum;

/**
 * Serializes PHP values to TOON format.
 */
class ToonSerializer
{
    public function __construct(
        private EncodeOptions $options
    ) {}

    public static function serialize(mixed $value, EncodeOptions $options): string
    {
        $serializer = new self($options);

        return $serializer->serializeValue($value);
    }

    private function serializeValue(mixed $value, int $depth = 0): string
    {

        return match (true) {
            is_null($value) => 'null',
            is_bool($value) => $value ? 'true' : 'false',
            is_int($value), is_float($value) => $this->serializeNumber($value),
            is_string($value) => $this->serializeString($value),
            $value instanceof DateTimeInterface => $this->serializeDateTime($value),
            $value instanceof UnitEnum => $this->serializeEnum($value),
            is_array($value) => $this->serializeArray($value, $depth),
            is_object($value) => $this->serializeObject($value, $depth),
            default => throw new EncodingException('Unsupported type: '.gettype($value)),
        };
    }

    private function serializeNumber(int|float $value): string
    {
        if (is_float($value) && (is_infinite($value) || is_nan($value))) {
            return 'null';
        }

        return (string) $value;
    }

    private function serializeString(string $value): string
    {
        // Quote if the value contains special characters or if forced
        if ($this->options->quoteStrings || $this->needsQuoting($value)) {
            return '"'.addslashes($value).'"';
        }

        return $value;
    }

    private function needsQuoting(string $value): bool
    {
        // Quote if contains delimiter, colons, newlines, or looks like a number/boolean/null
        if (str_contains($value, $this->options->delimiter->value) ||
            str_contains($value, ':') ||
            str_contains($value, "\n") ||
            str_contains($value, "\r") ||
            in_array(strtolower($value), ['true', 'false', 'null'], true) ||
            is_numeric($value)) {
            return true;
        }

        return false;
    }

    private function serializeDateTime(DateTimeInterface $value): string
    {
        return $this->serializeString($value->format(DateTime::ATOM));
    }

    private function serializeEnum(UnitEnum $value): string
    {
        if ($value instanceof BackedEnum) {
            return $this->serializeValue($value->value);
        }

        return $this->serializeString($value->name);
    }

    /**
     * @param  array<array-key, mixed>  $value
     */
    private function serializeArray(array $value, int $depth): string
    {
        if (empty($value)) {
            return '[]';
        }

        // Check if it's an associative array (object-like)
        if ($this->isAssociativeArray($value)) {
            return $this->serializeObject((object) $value, $depth);
        }

        // Check if we can use tabular format
        if ($this->options->preferTabular && $this->canUseTabularFormat($value)) {
            return $this->serializeTabularArray($value, $depth);
        }

        // Use simple array format
        return $this->serializeSimpleArray($value, $depth);
    }

    /**
     * @param  array<array-key, mixed>  $value
     */
    private function isAssociativeArray(array $value): bool
    {
        if (empty($value)) {
            return false;
        }

        return array_keys($value) !== range(0, count($value) - 1);
    }

    /**
     * @param  array<array-key, mixed>  $value
     */
    private function canUseTabularFormat(array $value): bool
    {
        if (empty($value)) {
            return false;
        }

        // Check if all elements are arrays/objects with the same keys
        $firstKeys = null;

        foreach ($value as $item) {
            if (! is_array($item) && ! is_object($item)) {
                return false;
            }

            $itemArray = (array) $item;
            $currentKeys = array_keys($itemArray);

            if ($this->options->sortKeys) {
                sort($currentKeys);
            }

            if ($firstKeys === null) {
                $firstKeys = $currentKeys;
            } elseif ($currentKeys !== $firstKeys) {
                return false;
            }
        }

        return $firstKeys !== [];
    }

    /**
     * @param  array<array-key, mixed>  $value
     */
    private function serializeSimpleArray(array $value, int $depth): string
    {
        $count = count($value);
        $delimiter = $this->options->delimiter->value;

        // Check if all values are primitives
        $allPrimitives = true;
        foreach ($value as $item) {
            if (is_array($item) || is_object($item)) {
                $allPrimitives = false;

                break;
            }
        }

        if ($allPrimitives) {
            // Inline format: [count]: value1,value2,value3
            $marker = $this->options->useLengthMarker ? "[{$count}]: " : '';
            $items = array_map(fn ($v) => $this->serializeValue($v, $depth), $value);

            return $marker.implode($delimiter, $items);
        }

        // Multi-line format for complex items
        $lines = [];
        $indent = $this->getIndent($depth);
        $nextIndent = $this->getIndent($depth + 1);

        foreach ($value as $index => $item) {
            $serialized = $this->serializeValue($item, $depth + 1);
            if (str_contains($serialized, "\n")) {
                $lines[] = $nextIndent.'- '.$index.':';
                foreach (explode("\n", $serialized) as $line) {
                    $lines[] = $nextIndent.'  '.$line;
                }
            } else {
                $lines[] = $nextIndent."- {$serialized}";
            }
        }

        return "\n".implode("\n", $lines);
    }

    /**
     * @param  array<array-key, mixed>  $value
     */
    private function serializeTabularArray(array $value, int $depth): string
    {
        if (empty($value)) {
            return '[]';
        }

        $firstItem = (array) $value[array_key_first($value)];
        $keys = array_keys($firstItem);

        if ($this->options->sortKeys) {
            sort($keys);
        }

        $delimiter = $this->options->delimiter->value;
        $count = count($value);
        $keyCount = count($keys);

        $marker = $this->options->useLengthMarker ? "[{$count}]" : '';
        $header = "{$marker}{".implode($delimiter, $keys).'}:';

        $lines = [$header];
        $indent = $this->getIndent($depth + 1);

        foreach ($value as $item) {
            $itemArray = (array) $item;
            $row = [];
            foreach ($keys as $key) {
                $row[] = $this->serializeValue($itemArray[$key] ?? null, 0);
            }
            $lines[] = $indent.implode($delimiter, $row);
        }

        return implode("\n", $lines);
    }

    /**
     * @param  object|array<array-key, mixed>  $value
     */
    private function serializeObject(object|array $value, int $depth): string
    {
        $array = (array) $value;

        if (empty($array)) {
            return '{}';
        }

        $lines = [];
        $indent = $this->getIndent($depth);
        $nextIndent = $this->getIndent($depth + 1);

        $keys = array_keys($array);
        if ($this->options->sortKeys) {
            sort($keys);
        }

        foreach ($keys as $key) {
            $val = $array[$key];
            $cleanKey = $this->cleanObjectKey($key);
            $serialized = $this->serializeValue($val, $depth + 1);

            if (str_contains($serialized, "\n")) {
                // Multi-line value
                $lines[] = $nextIndent.$cleanKey.':';
                foreach (explode("\n", $serialized) as $line) {
                    if ($line !== '') {
                        $lines[] = $nextIndent.$line;
                    }
                }
            } else {
                // Single-line value
                $lines[] = $nextIndent.$cleanKey.': '.$serialized;
            }
        }

        return $depth === 0 ? implode("\n", $lines) : "\n".implode("\n", $lines);
    }

    private function cleanObjectKey(string|int $key): string
    {
        $key = (string) $key;

        // Remove null byte prefix for private/protected properties
        if (str_contains($key, "\0")) {
            $parts = explode("\0", $key);
            $key = end($parts);
        }

        return $key;
    }

    private function getIndent(int $depth): string
    {
        if ($this->options->indent <= 0) {
            return '';
        }

        return str_repeat(' ', $depth * $this->options->indent);
    }
}
