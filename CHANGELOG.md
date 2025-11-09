# Changelog

All notable changes to `toon-php` will be documented in this file.

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
