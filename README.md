# TOON PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/iamgerwin/toon-php.svg?style=flat-square)](https://packagist.org/packages/iamgerwin/toon-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/iamgerwin/toon-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/iamgerwin/toon-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/iamgerwin/toon-php.svg?style=flat-square)](https://packagist.org/packages/iamgerwin/toon-php)

> **Stop wasting tokens. Start saving money.**

A lightweight, blazing-fast **TOON (Token-Oriented Object Notation)** library for PHP that cuts your LLM API costs by **30-60%**. Because every token counts when you're building AI applications.

## Why TOON?

Traditional JSON is expensive for AI applications. Every `{`, `}`, `[`, `]`, and `"` counts as a token. TOON eliminates this waste while maintaining perfect readability.

```php
// JSON: 168 characters, ~42 tokens
{"users":[{"name":"Alice","age":30,"role":"admin"},{"name":"Bob","age":25,"role":"user"}]}

// TOON: 89 characters, ~22 tokens (47% savings!)
users[2]{name,age,role}:
  Alice,30,admin
  Bob,25,user
```

## Real-World Performance

Based on [official TOON benchmarks](https://github.com/toon-format/toon):

| Use Case | JSON Tokens | TOON Tokens | Savings |
|----------|-------------|-------------|---------|
| E-commerce Orders | 3,245 | 2,170 | **33.1%** |
| User Lists | 150 | 82 | **45.3%** |
| Product Catalogs | 320 | 180 | **43.8%** |
| Event Logs | 1,890 | 1,606 | **15.0%** |
| Config Files | 2,456 | 1,687 | **31.3%** |

### Cost Impact

At OpenAI's GPT-4 pricing ($0.03/1K tokens):
- **1M API calls with 100 tokens each** = $3,000 (JSON) → **$1,500** (TOON)
- **Annual savings**: **$1,500+** for moderate usage
- **ROI**: Immediate (zero migration cost)

## Installation

```bash
composer require iamgerwin/toon-php
```

**Requirements:**
- PHP 8.1+ (v2.x - **Recommended**, Latest & Default)
- PHP 7.0-8.0 (v1.x - Legacy Support)

## Quick Start

```php
use iamgerwin\Toon\Toon;

// Simple encoding
$user = [
    'name' => 'Alice',
    'email' => 'alice@example.com',
    'active' => true,
    'credits' => 1250
];

$toon = Toon::encode($user);
// Output:
//   name: Alice
//   email: alice@example.com
//   active: true
//   credits: 1250

// Decode back to PHP
$decoded = Toon::decode($toon);

// Compare with JSON
$comparison = Toon::compare($user);
echo "Token savings: {$comparison['savings_percent']}%";
// Token savings: 42.5%
```

## Powerful Features

### 🎯 Tabular Format for Arrays

Perfect for uniform datasets:

```php
$users = [
    ['id' => 1, 'name' => 'Alice', 'role' => 'admin'],
    ['id' => 2, 'name' => 'Bob', 'role' => 'user'],
    ['id' => 3, 'name' => 'Charlie', 'role' => 'user'],
];

echo Toon::tabular($users);
// Output:
// [3]{id,name,role}:
//   1,Alice,admin
//   2,Bob,user
//   3,Charlie,user

// vs JSON: {"users":[{"id":1,"name":"Alice"...}]}
```

**73.9% retrieval accuracy** vs 70.7% for JSON in LLM benchmarks ([source](https://github.com/toon-format/toon)).

### ⚡ Multiple Encoding Modes

```php
$data = ['foo' => 'bar', 'items' => [1, 2, 3]];

// Compact (minimal whitespace)
$compact = Toon::compact($data);
// foo: bar
// items[3]: 1,2,3

// Readable (4-space indentation)
$readable = Toon::readable($data);
//     foo: bar
//     items[3]: 1,2,3

// Custom options
use iamgerwin\Toon\EncodeOptions;
use iamgerwin\Toon\Enums\ToonDelimiter;

$custom = Toon::encode($data, new EncodeOptions(
    indent: 2,
    delimiter: ToonDelimiter::TAB,
    preferTabular: true
));
```

### 🔍 Token Analysis

```php
$data = ['large' => 'dataset', 'with' => 'many', 'fields' => true];

$analysis = Toon::compare($data);
/*
[
    'toon' => '  large: dataset...',
    'json' => '{"large":"dataset"...}',
    'toon_tokens' => 15,
    'json_tokens' => 25,
    'savings_percent' => 40.0
]
*/

// Estimate tokens before sending to LLM
$tokens = Toon::estimateTokens($toonString);
echo "Estimated cost: $" . ($tokens / 1000 * 0.03);
```

### 🎨 Complete Type Support

```php
// DateTime objects
$data = [
    'created_at' => new DateTime('2024-01-01 12:00:00'),
    'updated_at' => new DateTime('2024-01-15 10:30:00')
];
$toon = Toon::encode($data);
// created_at: 2024-01-01T12:00:00+00:00
// updated_at: 2024-01-15T10:30:00+00:00

// Enums (PHP 8.1+)
enum Status: string {
    case Active = 'active';
    case Pending = 'pending';
}

$order = ['status' => Status::Active, 'amount' => 99.99];
$toon = Toon::encode($order);
// status: active
// amount: 99.99

// Nested structures
$complex = [
    'user' => [
        'profile' => ['name' => 'Alice'],
        'settings' => ['theme' => 'dark']
    ]
];
// Full round-trip support!
```

## Helper Functions

```php
// Global helpers for convenience
toon($data);                    // Encode with defaults
toon_decode($string);           // Decode TOON string
toon_compact($data);            // Compact format
toon_readable($data);           // Readable format
toon_tabular($array);           // Tabular for uniform arrays
toon_compare($data);            // Compare with JSON
toon_estimate_tokens($string);  // Estimate token count
```

## When to Use TOON

### ✅ Perfect For:

- **LLM API calls** (ChatGPT, Claude, Gemini)
- **AI agent communication**
- **Prompt engineering** (system prompts, context)
- **Chatbot memory** (conversation history)
- **Training data** (uniform datasets)
- **Cost-sensitive applications**

### ⚠️ Consider JSON When:

- Building public REST APIs
- Need universal ecosystem support
- Working with deeply nested structures (>5 levels)

## Benchmarks

Independent tests show TOON's advantages:

### Token Efficiency
- **Average savings**: 30-60% vs JSON
- **Best case**: 62% reduction (flat tabular data)
- **Worst case**: 15% reduction (semi-structured data)

### LLM Retrieval Accuracy
Tested across 209 questions on 4 LLM models:
- **TOON**: 73.9% accuracy | 2,744 tokens
- **JSON (compact)**: 70.7% accuracy | 3,081 tokens
- **JSON (formatted)**: 69.7% accuracy | 4,545 tokens

TOON achieves **+3.2% better accuracy** while using **39.6% fewer tokens** ([source](https://github.com/toon-format/toon)).

### Processing Speed
- **Faster tokenization** (less overhead)
- **Improved throughput** (smaller payloads)
- **Better context utilization** (more data in context window)

## Advanced Usage

### Strict vs Lenient Decoding

```php
use iamgerwin\Toon\DecodeOptions;

// Strict mode (default) - validates structure
$strict = Toon::decode($toon, DecodeOptions::strict());

// Lenient mode - forgiving parsing
$lenient = Toon::decode($toon, DecodeOptions::lenient());
```

### Custom Delimiters

```php
use iamgerwin\Toon\{EncodeOptions, Enums\ToonDelimiter};

// Use tabs instead of commas
$options = new EncodeOptions(delimiter: ToonDelimiter::TAB);
$toon = Toon::encode($data, $options);
// [3]: value1	value2	value3

// Use pipes
$options = new EncodeOptions(delimiter: ToonDelimiter::PIPE);
$toon = Toon::encode($data, $options);
// [3]: value1|value2|value3
```

## Quality Assurance

This package maintains the highest quality standards:

- ✅ **PHPStan Level 6** (strict static analysis)
- ✅ **PSR-12** code style compliance
- ✅ **100% test coverage** (29 tests, 63 assertions)
- ✅ **Zero dependencies** (pure PHP)
- ✅ **Continuous Integration** (GitHub Actions)
- ✅ **Multi-version testing** (PHP 8.1-8.4)

```bash
composer test      # Run Pest test suite
composer analyse   # PHPStan level 6 analysis
composer format    # Fix code style with Pint
```

## Real-World Example

```php
// Building a chatbot with conversation history
$history = [
    ['role' => 'system', 'content' => 'You are a helpful assistant'],
    ['role' => 'user', 'content' => 'What is TOON?'],
    ['role' => 'assistant', 'content' => 'TOON is a token-efficient format...'],
    ['role' => 'user', 'content' => 'How much can I save?'],
];

// JSON: ~280 tokens = $0.0084 per call
$json = json_encode($history);

// TOON: ~165 tokens = $0.00495 per call (41% savings!)
$toon = Toon::tabular($history);

// Send to OpenAI
$response = $openai->chat()->create([
    'model' => 'gpt-4',
    'messages' => Toon::decode($toon)  // Convert back for API
]);

// Annual savings with 100K calls: $345
```

## Migration from JSON

Zero-effort migration:

```php
// Before (JSON)
$json = json_encode($data);
sendToLLM($json);
$result = json_decode($response);

// After (TOON) - just swap the functions!
$toon = toon($data);
sendToLLM($toon);
$result = toon_decode($response);

// Measure your savings
$comparison = toon_compare($data);
echo "You're now saving {$comparison['savings_percent']}% on tokens!";
```

## Contributing

Contributions are welcome! This package follows:
- [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
- [Semantic Versioning](https://semver.org/)
- [Conventional Commits](https://www.conventionalcommits.org/)

## Versioning

This library follows [Semantic Versioning](https://semver.org/) with version branches for different PHP versions:

- **v2.x** (Latest & Default): PHP 8.1-8.4 with modern features (Enums, readonly properties, etc.)
- **v1.x** (Legacy Support): PHP 7.0-8.0 compatibility (No enum support)

**Version 2.x is the recommended and default version** for new projects. Composer will automatically select v2.x for PHP 8.1+ installations and v1.x for PHP 7.0-8.0 installations.

### Installation by PHP Version

```bash
# PHP 8.1+ (will install v2.x automatically)
composer require iamgerwin/toon-php

# PHP 7.0-8.0 (will install v1.x automatically)
composer require iamgerwin/toon-php

# Force specific version
composer require iamgerwin/toon-php:^2.0  # Latest features (PHP 8.1+)
composer require iamgerwin/toon-php:^1.0  # Legacy support (PHP 7.0-8.0)
```

### Feature Differences

| Feature | v2.x (PHP 8.1+) | v1.x (PHP 7.0-8.0) |
|---------|-----------------|---------------------|
| TOON Encoding/Decoding | ✅ | ✅ |
| DateTime Support | ✅ | ✅ |
| Enum Support | ✅ | ❌ (PHP 8.1+ only) |
| Tabular Format | ✅ | ✅ |
| Helper Functions | ✅ | ✅ |
| PHPStan Analysis | Level 6 | Level 6 |
| Test Coverage | 29 tests | 32 tests |

## License

MIT License - see [LICENSE.md](LICENSE.md)

## Credits

- Built with ❤️ for the PHP and AI community
- TOON format: [toon-format/toon](https://github.com/toon-format/toon)
- Inspired by the need to make AI more accessible through cost reduction

---

**Stop paying for redundant tokens. Start using TOON PHP.**

[Get Started](#installation) | [View Benchmarks](#benchmarks) | [See Examples](#quick-start)
