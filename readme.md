# HaveIBeenPwnedRangeChecker

A small, simple library for checking a password against the [HaveIBeenPwned password checker API](https://haveibeenpwned.com/API/v3#PwnedPasswords).

Passwords appearing in the search results of the API have appeared in breached databases, and thus any accounts using such a password are at greater risk of being breahced.

## Requirements

- PHP 7.1 or above
- Curl

## Installation

`composer require griffolion/pwned`

## Basic Usage

```php
use Pwned\Range;
...
$pwnedCount = Range::Check($passwordString);
if ($pwnedCount > 0) {
    echo "Your password is at risk!";
}
```