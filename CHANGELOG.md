# Changelog

All notable changes to `toon-php` will be documented in this file.

## v2.0.1 - Modern PHP 8.1+ (Latest) - 2025-11-09

### TOON PHP v2.0.1 - Modern PHP Support (Latest)

> **Recommended for all new projects** | PHP 8.1-8.4

A lightweight, blazing-fast TOON (Token-Oriented Object Notation) library for PHP that cuts your LLM API costs by **30-60%**.

#### 🎯 Version Information

- **PHP Support**: 8.1, 8.2, 8.3, 8.4
- **Branch**: [main](https://github.com/iamgerwin/toon-php)
- **Status**: ✅ **Latest & Default**

#### 📦 Installation

```bash
# Automatic (recommended)
composer require iamgerwin/toon-php

# Force v2.x
composer require iamgerwin/toon-php:^2.0

```
#### ✨ What's New in v2.0.1

##### Changed

- Updated PHP requirement to 8.1+ for enum support
- Enhanced documentation with version strategy
- Clarified versioning: v2.x (PHP 8.1+) is recommended & default, v1.x (PHP 7.0-8.0) for legacy support

#### 🚀 Features

- ✅ **Full Enum Support** (BackedEnum, UnitEnum)
- ✅ **Modern PHP 8.1+ Syntax** (constructor promotion, match expressions, arrow functions)
- ✅ **30-60% Token Savings** vs JSON
- ✅ **Zero Dependencies** (pure PHP)
- ✅ **PHPStan Level 6** (strict static analysis)
- ✅ **100% Test Coverage** (29 tests, 63 assertions)
- ✅ **PSR-12 Compliant**

#### 📊 Performance

Based on [official TOON benchmarks](https://github.com/toon-format/toon):

| Use Case | JSON Tokens | TOON Tokens | Savings |
|----------|-------------|-------------|---------|
| E-commerce Orders | 3,245 | 2,170 | **33.1%** |
| User Lists | 150 | 82 | **45.3%** |
| Product Catalogs | 320 | 180 | **43.8%** |

At OpenAI's GPT-4 pricing ($0.03/1K tokens):

- **1M API calls** = $3,000 (JSON) → **$1,500** (TOON)
- **Annual savings**: **$1,500+**

#### 🎨 Quick Example

```php
use iamgerwin\Toon\Toon;

// Encode with enum support (PHP 8.1+)
enum Status: string {
    case Active = 'active';
    case Pending = 'pending';
}

$order = [
    'id' => 123,
    'status' => Status::Active,
    'amount' => 99.99
];

$toon = Toon::encode($order);
// Output:
//   id: 123
//   status: active
//   amount: 99.99

// Tabular format
$users = [
    ['id' => 1, 'name' => 'Alice', 'role' => 'admin'],
    ['id' => 2, 'name' => 'Bob', 'role' => 'user'],
];

echo Toon::tabular($users);
// Output:
// [2]{id,name,role}:
//   1,Alice,admin
//   2,Bob,user

```
#### 📚 Documentation

- [README](https://github.com/iamgerwin/toon-php/blob/main/README.md)
- [CHANGELOG](https://github.com/iamgerwin/toon-php/blob/main/CHANGELOG.md)
- [Branch Structure](https://github.com/iamgerwin/toon-php/blob/main/BRANCH_STRUCTURE.md)

#### 🔄 Versions

- **v2.x** (This Release): PHP 8.1-8.4 with modern features - **Recommended**
- **[v1.x](https://github.com/iamgerwin/toon-php/releases/tag/v1.0.0)**: PHP 7.0-8.0 compatibility - Legacy Support

#### 📋 Full Changelog

See [CHANGELOG.md](https://github.com/iamgerwin/toon-php/blob/main/CHANGELOG.md) for complete details.


---

**Made with ❤️ for the PHP and AI community**

## v2.0.1 - 2025-11-09

### Changed

- Updated PHP requirement to 8.1+ for enum support
- Updated README with version strategy documentation
- Clarified versioning: v2.x (PHP 8.1+) is recommended & default, v1.x (PHP 7.0-8.0) for legacy support

## v1.0.0 - 2025-11-09

Legacy PHP support release for PHP 7.0-8.0

### Added

- Complete TOON encoding and decoding for PHP 7.0-8.0
- Support for all PHP data types (except Enums - PHP 8.1+ only)
- Multiple formatting modes (compact, readable, tabular)
- Helper functions for common operations
- PHPStan level 6 compliance
- PSR-12 code style
- Comprehensive test coverage (32 tests)
- PHP 7.0-8.0 compatibility

### Technical Details

- Removed enum support (PHP 8.1+ feature)
- Converted constructor property promotion to traditional syntax
- Replaced `mixed` type hints with docblock annotations
- Replaced match expressions with if/else statements
- Replaced arrow functions with traditional closures
- Replaced `str_contains`, `str_starts_with`, `str_ends_with` with `strpos`
- Enum class converted to constants class
- Full PHP 7.0 compatibility maintained

## v2.0.0 - Initial Release - 2025-11-09

### TOON PHP v2.0.0

A lightweight, fast, and feature-rich TOON (Token-Oriented Object Notation) library for PHP. Optimized for LLM contexts with 30-60% token savings compared to JSON.

#### Features

- 🚀 Complete TOON format encoding/decoding
- 🔒 Type safe with PHPStan level 9
- 📦 Zero dependencies
- 🎯 30-60% token savings vs JSON
- 🧪 100% test coverage (33 tests passing)
- 🎨 Multiple formatting modes (compact, readable, tabular)
- ✨ PHP 8.0-8.4 support

#### What's Included

- Complete TOON serialization and deserialization
- Support for all PHP data types (primitives, arrays, objects, DateTime, Enums)
- Multiple encoding modes with customizable options
- Helper functions for common operations
- Comprehensive test suite with Pest
- PSR-12 code style compliance
- PHPStan level 9 static analysis

#### Installation

```bash
composer require iamgerwin/toon-php


```
#### Quick Start

```php
use iamgerwin\Toon\Toon;

$data = ['name' => 'John', 'age' => 30];
$toon = Toon::encode($data);
$decoded = Toon::decode($toon);


```
#### Documentation

See [README.md](https://github.com/iamgerwin/toon-php/blob/main/README.md) for full documentation.

#### Credits

Made with ❤️ for the PHP and AI community

## 2.0.0 - 2025-11-09

Initial release with full TOON format support for PHP 8.0+

### Added

- Complete TOON encoding and decoding
- Support for all PHP data types
- Multiple formatting modes (compact, readable, tabular)
- Helper functions for common operations
- PHPStan level 9 compliance
- PSR-12 code style
- Comprehensive test coverage
- PHP 8.0-8.4 support
