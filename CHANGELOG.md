# Changelog

All notable changes to `toon-php` will be documented in this file.

## 1.0.0 - 2025-11-09

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
