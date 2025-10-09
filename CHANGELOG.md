# Similar Changelog

## 4.0.3 - 2025.10.09
### Fixed
* Fixed an issue where having empty elements or empty tags could cause an exception to be thrown, seemingly due to a change in Craft CMS ([#55](https://github.com/nystudio107/craft-similar/issues/55))

## 4.0.2 - 2024.06.20
### Fixed
* Fixed an issue where `toArray()` was done recursively on the passed in `$critera`, which turned objects into sub-arrays in `orderBy` and other properties, causing a DB error ([#51](https://github.com/nystudio107/craft-similar/issues/51)) ([#50](https://github.com/nystudio107/craft-similar/issues/50))

## 4.0.1 - 2024.04.28
### Added
* Added `ServicesTrait` for the plugin service component registration
* Add `phpstan` and `ecs` code linting
* Add `code-analysis.yaml` GitHub action

### Changed
* Updated docs to use node 20 & a new sitemap plugin
* PHPstan code cleanup
* ECS code cleanup

### Fixed
* Fixed an issue where an exception would be thrown if `orderBy` was `null` ([#49](https://github.com/nystudio107/craft-similar/issues/49))

## 4.0.0 - 2022.05.09
### Added
* Initial Craft CMS 4 release

### Fixed
* Fixed an issue where passing an `ElementQuery` into `criteria` would cause it to throw a type error ([#44](https://github.com/nystudio107/craft-similar/issues/44))

## 4.0.0-beta.1 - 2022.03.15

### Added

* Initial Craft CMS 4 compatibility
