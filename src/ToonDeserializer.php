<?php

declare(strict_types=1);

namespace iamgerwin\Toon;

use iamgerwin\Toon\Exceptions\DecodingException;

/**
 * Deserializes TOON format to PHP values.
 */
class ToonDeserializer
{
    /**
     * @var list<string>
     */
    private $lines = [];

    /**
     * @var int
     */
    private $currentLine = 0;

    /**
     * @var DecodeOptions
     */
    private $options;

    public function __construct(DecodeOptions $options)
    {
        $this->options = $options;
        $this->lines = [];
        $this->currentLine = 0;
    }

    /**
     * @param string $toon
     * @param DecodeOptions $options
     * @return mixed
     */
    public static function deserialize(string $toon, DecodeOptions $options)
    {
        $deserializer = new self($options);

        return $deserializer->parse($toon);
    }

    /**
     * @param string $toon
     * @return mixed
     */
    private function parse(string $toon)
    {
        $toon = trim($toon);

        if ($toon === '') {
            return null;
        }

        $this->lines = explode("\n", $toon);
        $this->currentLine = 0;

        return $this->parseValue();
    }

    /**
     * @return mixed
     */
    private function parseValue()
    {
        if ($this->currentLine >= count($this->lines)) {
            return null;
        }

        $line = trim($this->lines[$this->currentLine]);

        // Empty line
        if ($line === '') {
            $this->currentLine++;

            return $this->parseValue();
        }

        // Check for object (key: value pattern)
        if ($this->isObjectStart($line)) {
            return $this->parseObject();
        }

        // Check for array
        if ($this->isArrayStart($line)) {
            return $this->parseArray();
        }

        // Parse primitive value
        $this->currentLine++;

        return $this->parsePrimitive($line);
    }

    private function isObjectStart(string $line): bool
    {
        // Line contains a colon that's not part of array syntax
        // Exclude array patterns like [count]{keys}: or [count]:
        if (preg_match('/^\[(\d+)\]/', $line) === 1) {
            return false;
        }

        return strpos($line, ':') !== false;
    }

    private function isArrayStart(string $line): bool
    {
        // Line starts with array marker [...] or tabular format
        return preg_match('/^\[(\d+)\]/', $line) === 1 ||
               preg_match('/^\[(\d+)\]\{/', $line) === 1 ||
               (substr($line, 0, 1) === '[');
    }

    /**
     * @return array<string, mixed>|object
     */
    private function parseObject()
    {
        $result = [];
        $baseIndent = $this->getIndentLevel($this->lines[$this->currentLine]);

        while ($this->currentLine < count($this->lines)) {
            $line = $this->lines[$this->currentLine];
            $trimmed = trim($line);

            if ($trimmed === '') {
                $this->currentLine++;

                continue;
            }

            $indent = $this->getIndentLevel($line);

            // If indent is less than base, we've finished this object
            if ($indent < $baseIndent && $this->currentLine > 0) {
                break;
            }

            // Parse key-value pair
            if (strpos($trimmed, ':') === false) {
                break;
            }

            list($key, $valueStr) = explode(':', $trimmed, 2);
            $key = trim($key);
            $valueStr = trim($valueStr);

            $this->currentLine++;

            if ($valueStr === '') {
                // Multi-line value - check next lines
                $value = $this->parseNestedValue($indent);
            } else {
                // Single-line value
                $value = $this->parsePrimitive($valueStr);
            }

            $result[$key] = $value;
        }

        return $this->options->associative ? $result : (object) $result;
    }

    /**
     * @param int $parentIndent
     * @return mixed
     */
    private function parseNestedValue(int $parentIndent)
    {
        if ($this->currentLine >= count($this->lines)) {
            return null;
        }

        $nextLine = $this->lines[$this->currentLine];
        $nextIndent = $this->getIndentLevel($nextLine);

        // Check if next line is indented more (nested value)
        if ($nextIndent <= $parentIndent) {
            return null;
        }

        return $this->parseValue();
    }

    /**
     * @return list<mixed>
     */
    private function parseArray(): array
    {
        $line = trim($this->lines[$this->currentLine]);

        // Check for tabular format: [count]{keys}:
        if (preg_match('/^\[(\d+)\]\{([^\}]+)\}:\s*$/', $line, $matches)) {
            return $this->parseTabularArray($matches[1], $matches[2]);
        }

        // Check for simple array with count: [count]: values
        if (preg_match('/^\[(\d+)\]:\s*(.+)$/', $line, $matches)) {
            $this->currentLine++;

            return $this->parseSimpleArray($matches[2], (int) $matches[1]);
        }

        // Check for inline array without count
        if (preg_match('/^\[\]|\[([^\]]*)\]/', $line, $matches)) {
            $this->currentLine++;
            if (! isset($matches[1]) || $matches[1] === '') {
                return [];
            }

            return $this->parseSimpleArray($matches[1]);
        }

        $this->currentLine++;

        return [];
    }

    /**
     * @param string $values
     * @param int|null $expectedCount
     * @return array<int, mixed>
     */
    private function parseSimpleArray(string $values, $expectedCount = null): array
    {
        // Try comma first, then tab, then pipe
        $delimiter = ',';
        if (strpos($values, "\t") !== false) {
            $delimiter = "\t";
        } elseif (strpos($values, '|') !== false) {
            $delimiter = '|';
        }

        $parts = explode($delimiter, $values);
        $result = [];

        foreach ($parts as $part) {
            $result[] = $this->parsePrimitive(trim($part));
        }

        if ($this->options->strict && $expectedCount !== null && count($result) !== $expectedCount) {
            throw new DecodingException(
                "Array count mismatch: expected {$expectedCount}, got ".count($result)
            );
        }

        return $result;
    }

    /**
     * @param string $count
     * @param string $keysStr
     * @return array<int, array<string, mixed>|object>
     */
    private function parseTabularArray(string $count, string $keysStr): array
    {
        $expectedCount = (int) $count;

        // Parse keys
        $delimiter = ',';
        if (strpos($keysStr, "\t") !== false) {
            $delimiter = "\t";
        } elseif (strpos($keysStr, '|') !== false) {
            $delimiter = '|';
        }

        $keys = array_map('trim', explode($delimiter, $keysStr));
        $result = [];

        $this->currentLine++;
        $baseIndent = null;

        for ($i = 0; $i < $expectedCount; $i++) {
            if ($this->currentLine >= count($this->lines)) {
                if ($this->options->strict) {
                    throw new DecodingException(
                        "Tabular array incomplete: expected {$expectedCount} rows, got {$i}"
                    );
                }

                break;
            }

            $line = $this->lines[$this->currentLine];
            $indent = $this->getIndentLevel($line);

            if ($baseIndent === null) {
                $baseIndent = $indent;
            } elseif ($indent < $baseIndent) {
                if ($this->options->strict) {
                    throw new DecodingException(
                        "Tabular array incomplete: expected {$expectedCount} rows, got {$i}"
                    );
                }

                break;
            }

            $trimmed = trim($line);
            $values = $this->parseSimpleArray($trimmed);

            if ($this->options->strict && count($values) !== count($keys)) {
                throw new DecodingException(
                    "Tabular array column count mismatch on row {$i}: expected ".count($keys).', got '.count($values)
                );
            }

            $row = [];
            foreach ($keys as $index => $key) {
                $row[$key] = $values[$index] ?? null;
            }

            $result[] = $this->options->associative ? $row : (object) $row;
            $this->currentLine++;
        }

        return $result;
    }

    /**
     * @param string $value
     * @return mixed
     */
    private function parsePrimitive(string $value)
    {
        $value = trim($value);

        // Null
        if ($value === 'null') {
            return null;
        }

        // Boolean
        if ($value === 'true') {
            return true;
        }
        if ($value === 'false') {
            return false;
        }

        // Quoted string
        if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
            (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
            return stripslashes(substr($value, 1, -1));
        }

        // Number
        if (is_numeric($value)) {
            if (strpos($value, '.') !== false || strpos($value, 'e') !== false || strpos($value, 'E') !== false) {
                return (float) $value;
            }

            return (int) $value;
        }

        // String
        return $value;
    }

    private function getIndentLevel(string $line): int
    {
        $count = 0;
        $len = strlen($line);

        for ($i = 0; $i < $len; $i++) {
            if ($line[$i] === ' ') {
                $count++;
            } elseif ($line[$i] === "\t") {
                if ($this->options->strict) {
                    throw new DecodingException('Tabs not allowed for indentation in strict mode');
                }
                $count += 4; // Treat tab as 4 spaces
            } else {
                break;
            }
        }

        return $count;
    }
}
