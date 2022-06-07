[![Latest Version on Packagist](https://img.shields.io/packagist/v/phpsa/filament-password-reveal.svg?style=flat-square)](https://packagist.org/packages/phpsa/filament-password-reveal)
[![Semantic Release](https://github.com/phpsa/filament-password-reveal/actions/workflows/release.yml/badge.svg)](https://github.com/phpsa/filament-password-reveal/actions/workflows/release.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/phpsa/filament-password-reveal.svg?style=flat-square)](https://packagist.org/packages/phpsa/filament-password-reveal)

# Filament Password Reveal Input

Password input that shows/hides the password when clicking on the eye

## Installation

You can install the package via composer:

```bash
composer require phpsa/filament-password-reveal
```

## Usage

`Password::make('password')->autocomplete('new_password')->...`

additional methods:
### Methods that allow some extendability
- Password Reveal
- - `...->[revealable(bool|Closure $condition)` - default: true
- - `...->showIcon(string $icon)` - default: heroicon-o-eye
- - `...->hideIcon(string $hide)]` - default: heroicon-o-eye-open

- Password Copy to Clipboard
- - `...->copyable(bool|Closure)` default: false
- - `...->copyIcon(string $icon)]` default: heroicon-o-clipboard

- Generate Password
`...->generatable(bool|Closure)` default: false
`...->generateIcon($icon)` default: heroicon-o-key
`...->passwordLength(int)` default: 8
`...->passwordUsesNumbers(bool)` default: true
`...->passwordUsesSymbols(bool)` default: true

All three can be enabled at the same time.
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Phpsa](https://github.com/phpsa)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
