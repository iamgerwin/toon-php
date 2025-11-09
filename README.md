# TOON PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/iamgerwin/toon-php.svg?style=flat-square)](https://packagist.org/packages/iamgerwin/toon-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/iamgerwin/toon-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/iamgerwin/toon-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/iamgerwin/toon-php.svg?style=flat-square)](https://packagist.org/packages/iamgerwin/toon-php)

A lightweight, fast, and feature-rich **TOON (Token-Oriented Object Notation)** library for PHP. Optimized for LLM contexts with **30-60% token savings** compared to JSON.

## Installation

```bash
composer require iamgerwin/toon-php
```

Requires PHP 8.0 or higher.

## Quick Start

```php
use iamgerwin\Toon\Toon;

// Encode to TOON
\$data = ['name' => 'John', 'age' => 30];
\$toon = Toon::encode(\$data);

// Decode from TOON  
\$decoded = Toon::decode(\$toon);

// Use helpers
\$compact = toon_compact(\$data);
\$readable = toon_readable(\$data);
```

## Features

- 🚀 Lightning fast encoding/decoding
- 🔒 Type safe with PHPStan level 9
- 📦 Zero dependencies
- 🎯 30-60% token savings vs JSON
- 🧪 100% test coverage
- 🎨 Multiple formatting modes
- ✨ PHP 8.0-8.4 support

## Testing

```bash
composer test
composer analyse
composer format
```

## License

MIT License. See [LICENSE.md](LICENSE.md) for details.
