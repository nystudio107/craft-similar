# Similar Changelog

## 5.0.1 - UNRELEASED
### Fixed
* Filter out `OrderByPlaceholderExpression` expressions from the `orderBy` clause in the `ElementQuery` to prevent invalid SQL from being generated ([#51](https://github.com/nystudio107/craft-similar/issues/51)) ([#52](https://github.com/nystudio107/craft-similar/issues/52))

* Fixed a `SQLSTATE[42S22]: Column not found: 1054 Unknown column 'content.id' in 'group statement'` error on Craft 5 ([#51](https://github.com/nystudio107/craft-similar/issues/51))

## 5.0.0 - 2024.04.28
### Added
* Stable release for Craft CMS 5
