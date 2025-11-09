# TOON PHP - Legacy Version (v1.x)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/iamgerwin/toon-php.svg?style=flat-square)](https://packagist.org/packages/iamgerwin/toon-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/iamgerwin/toon-php/run-tests.yml?branch=legacy&label=tests&style=flat-square)](https://github.com/iamgerwin/toon-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/iamgerwin/toon-php.svg?style=flat-square)](https://packagist.org/packages/iamgerwin/toon-php)

> **Legacy PHP 7.0-8.0 Support** | For modern PHP 8.1+ features, see [main branch (v2.x)](https://github.com/iamgerwin/toon-php)

A lightweight, blazing-fast **TOON (Token-Oriented Object Notation)** library for PHP that cuts your LLM API costs by **30-60%**. This is the **legacy version** supporting **PHP 7.0 through 8.0**.

## 🎯 Version Information

- **Version**: v1.x (Legacy Support)
- **PHP Support**: 7.0, 7.1, 7.2, 7.3, 7.4, 8.0
- **Branch**: `legacy`
- **Status**: Production Ready

### Looking for Modern Features?

If you're on **PHP 8.1+**, use the **[main branch (v2.x)](https://github.com/iamgerwin/toon-php)** which includes:
- ✅ Full enum support (BackedEnum, UnitEnum)
- ✅ Modern PHP 8.1+ syntax
- ✅ Constructor property promotion
- ✅ Match expressions and arrow functions

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

## Installation

```bash
composer require iamgerwin/toon-php:^1.0
```

**Requirements:**
- PHP 7.0 - 8.0

**Automatic Version Selection:**
```bash
# Composer automatically selects v1.x for PHP 7.0-8.0
composer require iamgerwin/toon-php
```

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
```

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
    2,                      // indent
    ToonDelimiter::TAB,     // delimiter
    true,                   // useLengthMarker
    true                    // preferTabular
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

// Nested structures
$complex = [
    'user' => [
        'profile' => ['name' => 'Alice'],
        'settings' => ['theme' => 'dark']
    ]
];
// Full round-trip support!
```

**Note:** Enums are NOT supported in v1.x (PHP 7.0-8.0). Enum support requires PHP 8.1+ and is available in [v2.x](https://github.com/iamgerwin/toon-php).

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

## Quality Assurance

This package maintains the highest quality standards:

- ✅ **PHPStan Level 6** (strict static analysis)
- ✅ **PSR-12** code style compliance
- ✅ **100% test coverage** (32 tests, 66 assertions)
- ✅ **Zero dependencies** (pure PHP)
- ✅ **Continuous Integration** (GitHub Actions)
- ✅ **Multi-version testing** (PHP 7.0-8.0)

```bash
composer test      # Run Pest test suite
composer analyse   # PHPStan level 6 analysis
composer format    # Fix code style with Pint
```

## Legacy Version Differences

This v1.x branch uses traditional PHP syntax compatible with PHP 7.0:

| Feature | v1.x (Legacy) | v2.x (Modern) |
|---------|---------------|---------------|
| **PHP Version** | 7.0 - 8.0 | 8.1 - 8.4 |
| **Enum Support** | ❌ | ✅ |
| **DateTime Support** | ✅ | ✅ |
| **Tabular Format** | ✅ | ✅ |
| **Token Savings** | 30-60% | 30-60% |
| **Constructor Promotion** | ❌ | ✅ |
| **Match Expressions** | ❌ (uses if/else) | ✅ |
| **Arrow Functions** | ❌ (traditional closures) | ✅ |
| **PHPStan Level** | Level 6 | Level 6 |

### Technical Implementation

**v1.x uses traditional syntax:**
```php
// Traditional constructor
/** @var EncodeOptions */
private $options;

public function __construct(EncodeOptions $options) {
    $this->options = $options;
}

// Constants class (no enums)
class ToonDelimiter {
    public const COMMA = ',';
    public const TAB = "\t";
    public const PIPE = '|';
}

// Traditional conditionals
if (is_null($value)) {
    return 'null';
}
if (is_bool($value)) {
    return $value ? 'true' : 'false';
}

// Traditional closures
$items = array_map(function ($v) use ($depth) {
    return $this->serializeValue($v, $depth);
}, $value);

// strpos instead of str_contains
if (strpos($value, "\n") !== false) {
    // handle multiline
}
```

## When to Use v1.x vs v2.x

### ✅ Use v1.x (Legacy) If:
- You're on PHP 7.0 - 8.0
- You need backward compatibility
- You're maintaining legacy applications
- You can't upgrade to PHP 8.1+

### ⬆️ Upgrade to v2.x If:
- You're on PHP 8.1+
- You want enum support
- You want modern PHP syntax
- You're starting a new project

## Real-World Performance

Based on [official TOON benchmarks](https://github.com/toon-format/toon):

| Use Case | JSON Tokens | TOON Tokens | Savings |
|----------|-------------|-------------|---------  |
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

**Bug fixes for v1.x:** Submit PRs to the `legacy` branch

**New features:** Consider targeting [v2.x (main branch)](https://github.com/iamgerwin/toon-php) for modern PHP support

## Versioning

- **v1.x** (Legacy Branch): PHP 7.0-8.0 compatibility
- **v2.x** (Main Branch): PHP 8.1-8.4 with modern features

Composer automatically selects the right version for your PHP installation.

## License

MIT License - see [LICENSE.md](LICENSE.md)

## Credits

- Built with ❤️ for the PHP and AI community
- TOON format: [toon-format/toon](https://github.com/toon-format/toon)
- Inspired by the need to make AI more accessible through cost reduction

---

**Legacy Support for PHP 7.0-8.0 | Looking for modern features? Check out [v2.x](https://github.com/iamgerwin/toon-php)**

[Get Started](#installation) | [View Tests](tests/) | [See Benchmarks](#real-world-performance)
