# Similar Changelog

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
