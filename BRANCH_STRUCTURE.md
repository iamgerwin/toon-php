# TOON PHP - Branch & Version Structure

## 📦 Branch Overview

This repository maintains two separate branches for different PHP version support:

### **main** (v2.x) - Modern PHP 8.1+
- **Status**: ✅ Active Development, Latest & Default
- **PHP Support**: 8.1, 8.2, 8.3, 8.4
- **Latest Tag**: v2.0.3
- **Features**: Full enum support, modern PHP syntax
- **GitHub**: https://github.com/iamgerwin/toon-php

### **legacy** (v1.x) - Legacy PHP 7.0-8.0
- **Status**: ✅ Maintenance Mode (Bug Fixes Only)
- **PHP Support**: 7.0, 7.1, 7.2, 7.3, 7.4, 8.0
- **Latest Tag**: v1.0.2
- **Features**: Traditional PHP syntax, no enums
- **GitHub**: https://github.com/iamgerwin/toon-php/tree/legacy

---

## 🏷️ Tag Structure

| Tag | Branch | PHP Version | Status | Release Date |
|-----|--------|-------------|--------|--------------|
| **v2.0.3** | main | 8.1-8.4 | **Latest & Default** | 2026-01-25 |
| v2.0.2 | main | 8.1-8.4 | Superseded | 2025-11-09 |
| v2.0.1 | main | 8.1-8.4 | Superseded | 2025-11-09 |
| **v1.0.2** | legacy | 7.0-8.0 | **Legacy Support** | 2026-01-25 |
| v1.0.1 | legacy | 7.0-8.0 | Superseded | 2025-11-09 |
| v1.0.0 | legacy | 7.0-8.0 | Superseded | 2025-11-09 |

---

## 🎯 Composer Version Selection

Composer automatically selects the correct version based on your PHP installation:

```bash
# PHP 8.1+ → Installs v2.0.3 (from main branch)
composer require iamgerwin/toon-php

# PHP 7.0-8.0 → Installs v1.0.2 (from legacy branch)
composer require iamgerwin/toon-php

# Force specific version
composer require iamgerwin/toon-php:^2.0  # main branch (PHP 8.1+)
composer require iamgerwin/toon-php:^1.0  # legacy branch (PHP 7.0-8.0)
```

**v2.x is set as the default** - Packagist will mark v2.0.3 as the latest version.

---

## 🔄 Development Workflow

### For v2.x (main branch)
```bash
git checkout main
# Make changes
git add .
git commit -m "feat: add new feature"
git push origin main
# When ready to release:
git tag -a v2.x.x -m "Release v2.x.x"
git push origin v2.x.x
```

### For v1.x (legacy branch)
```bash
git checkout legacy
# Make bug fixes only
git add .
git commit -m "fix: bug description"
git push origin legacy
# When ready to release:
git tag -a v1.x.x -m "Release v1.x.x"
git push origin v1.x.x
```

---

## 📂 Branch-Specific Documentation

Each branch has its own tailored documentation:

### main Branch
- **README.md** - Modern PHP 8.1+ features with enums
- **CHANGELOG.md** - v2.x changelog entries
- **PROJECT_SUMMARY.md** - v2.x project summary
- Links to legacy branch for PHP 7.0-8.0 users

### legacy Branch
- **README.md** - Legacy PHP 7.0-8.0 support (no enums)
- **CHANGELOG.md** - v1.x changelog entries only
- **PROJECT_SUMMARY.md** - v1.x project summary
- Links to main branch for modern features

---

## ✅ Quality Checks

Both branches maintain high quality standards:

| Check | main (v2.x) | legacy (v1.x) |
|-------|-------------|---------------|
| **PHPStan** | Level 6 ✅ | Level 6 ✅ |
| **Code Style** | PSR-12 ✅ | PSR-12 ✅ |
| **Tests** | 29 passing ✅ | 32 passing ✅ |
| **CI/CD** | PHP 8.1-8.4 ✅ | PHP 7.0-8.0 ✅ |

---

## 🆚 Feature Comparison

| Feature | main (v2.x) | legacy (v1.x) |
|---------|-------------|---------------|
| **Enum Support** | ✅ Full support | ❌ Not available |
| **Constructor Promotion** | ✅ Yes | ❌ Traditional syntax |
| **Match Expressions** | ✅ Yes | ❌ Uses if/else |
| **Arrow Functions** | ✅ Yes | ❌ Traditional closures |
| **TOON Encoding** | ✅ Yes | ✅ Yes |
| **DateTime Support** | ✅ Yes | ✅ Yes |
| **Tabular Format** | ✅ Yes | ✅ Yes |
| **Token Savings** | 30-60% | 30-60% |

---

## 🚀 GitHub Actions

Both branches have CI/CD configured:

### main Branch
- **Workflow**: `.github/workflows/run-tests.yml`
- **PHP Versions**: 8.1, 8.2, 8.3, 8.4
- **OS**: Ubuntu, Windows
- **Triggers**: Push to main, pull requests

### legacy Branch
- **Workflow**: `.github/workflows/run-tests.yml`
- **PHP Versions**: 7.0, 7.1, 7.2, 7.3, 7.4, 8.0
- **OS**: Ubuntu, Windows
- **Triggers**: Push to legacy, pull requests

---

## 📋 Maintenance Policy

### main Branch (v2.x)
- ✅ **Active development** - New features, improvements, bug fixes
- ✅ **Regular updates** - Ongoing maintenance
- ✅ **Recommended** for all new projects

### legacy Branch (v1.x)
- ⚠️ **Maintenance mode** - Bug fixes only
- ❌ **No new features** - Feature development on main only
- ✅ **Supported** for legacy PHP applications

---

## 🔗 Important Links

- **Main Branch**: https://github.com/iamgerwin/toon-php
- **Legacy Branch**: https://github.com/iamgerwin/toon-php/tree/legacy
- **Latest Release (v2.0.1)**: https://github.com/iamgerwin/toon-php/releases/tag/v2.0.1
- **Legacy Release (v1.0.0)**: https://github.com/iamgerwin/toon-php/releases/tag/v1.0.0
- **Packagist**: https://packagist.org/packages/iamgerwin/toon-php

---

## 🎯 Summary

✅ **Two branches**: `main` (v2.x, PHP 8.1+) and `legacy` (v1.x, PHP 7.0-8.0)
✅ **Separate tags**: v2.0.1 (latest), v1.0.0 (legacy)
✅ **Automatic selection**: Composer picks the right version
✅ **v2.x is default**: Recommended for all new projects
✅ **v1.x supported**: For legacy PHP applications
✅ **Clean separation**: No interference between versions
✅ **Full documentation**: Each branch has tailored docs

**Status**: 🎉 Both versions production ready!
