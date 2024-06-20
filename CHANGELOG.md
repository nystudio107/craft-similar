# Similar Changelog

## 5.0.2 - 2024.06.20
### Fixed
* Fixed an issue where `toArray()` was done recursively on the passed in `$critera`, which turned objects into sub-arrays in `orderBy` and other properties, causing a DB error ([#51](https://github.com/nystudio107/craft-similar/issues/51)) ([#50](https://github.com/nystudio107/craft-similar/issues/50))

## 5.0.1 - 2024.06.19
### Fixed
* Filter out `OrderByPlaceholderExpression` expressions from the `orderBy` clause in the `ElementQuery` to prevent invalid SQL from being generated ([#51](https://github.com/nystudio107/craft-similar/issues/51)) ([#52](https://github.com/nystudio107/craft-similar/issues/52))
* Fixed a `SQLSTATE[42S22]: Column not found: 1054 Unknown column 'content.id' in 'group statement'` error on Craft 5 ([#51](https://github.com/nystudio107/craft-similar/issues/51))

## 5.0.0 - 2024.04.28
### Added
* Stable release for Craft CMS 5
