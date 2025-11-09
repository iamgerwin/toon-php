# Changelog - Legacy Branch (v1.x)

All notable changes to the **legacy version** of `toon-php` (PHP 7.0-8.0) will be documented in this file.

> **For the latest version (PHP 8.1+)**, see the [main branch CHANGELOG](https://github.com/iamgerwin/toon-php/blob/main/CHANGELOG.md)

## 1.0.0 - 2025-11-09

Initial legacy release with PHP 7.0-8.0 compatibility

### Added
- ✅ Complete TOON encoding and decoding for PHP 7.0-8.0
- ✅ Support for all PHP data types (except Enums - PHP 8.1+ only)
- ✅ Multiple formatting modes (compact, readable, tabular)
- ✅ Tabular array format for uniform datasets
- ✅ Helper functions for common operations (7 functions)
- ✅ Token estimation and JSON comparison utilities
- ✅ PHPStan level 6 compliance
- ✅ PSR-12 code style
- ✅ Comprehensive test coverage (32 tests, 66 assertions)
- ✅ Zero runtime dependencies
- ✅ PHP 7.0, 7.1, 7.2, 7.3, 7.4, 8.0 support
- ✅ GitHub Actions CI/CD for all PHP 7.x and 8.0 versions

### Features
- **30-60% token savings** compared to JSON
- DateTime object support
- Nested structure support (arrays and objects)
- Customizable encoding options (indent, delimiter, format preferences)
- Strict and lenient decoding modes
- Custom delimiter support (comma, tab, pipe)

### Technical Implementation
- ❌ **No enum support** (PHP 8.1+ feature not available)
- ✅ Traditional constructor syntax (no property promotion)
- ✅ Docblock type annotations instead of `mixed` type hints
- ✅ If/else conditionals instead of match expressions
- ✅ Traditional closures instead of arrow functions
- ✅ `strpos()` instead of `str_contains()`, `str_starts_with()`, `str_ends_with()`
- ✅ ToonDelimiter as constants class instead of enum
- ✅ Full backward compatibility to PHP 7.0

### Documentation
- Comprehensive README for legacy version
- Installation instructions for PHP 7.0-8.0
- Version comparison table (v1.x vs v2.x)
- Migration guide from JSON to TOON
- Real-world performance benchmarks
- Technical implementation details

### Quality Assurance
- All 32 tests passing across PHP 7.0-8.0
- PHPStan level 6 analysis with zero errors
- PSR-12 code style compliance
- Multi-version testing in CI/CD

---

**Note:** This changelog is for the `legacy` branch (v1.x) supporting PHP 7.0-8.0. For the latest features and modern PHP support (8.1+), see [v2.x on main branch](https://github.com/iamgerwin/toon-php).
