# Similar Changelog

## 1.1.8 - UNRELEASED
### Fixed
* Fixed an issue where having empty elements or empty tags could cause an exception to be thrown, seemingly due to a change in Craft CMS ([#55](https://github.com/nystudio107/craft-similar/issues/55))

## 1.1.7 - 2024.06.20
### Fixed
* Fixed an issue where `toArray()` was done recursively on the passed in `$critera`, which turned objects into sub-arrays in `orderBy` and other properties, causing a DB error ([#51](https://github.com/nystudio107/craft-similar/issues/51)) ([#50](https://github.com/nystudio107/craft-similar/issues/50))

## 1.1.6 - 2024.04.28
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

## 1.1.5 - 2021.06.03
### Changed
* If `orderBy` criteria is omitted, entries are now sorted by the number of relations in common. (https://github.com/nystudio107/craft-similar/issues/35)
* Switch to VitePress for documentation
* Updated `Makefile` to use `node-14-alpine`

## 1.1.4 - 2021.03.27
### Changed
* Move settings from the `composer.json` “extra” to the plugin main class

## 1.1.3 - 2021.03.27
### Fixed
* Fixed an issue with using `RAND()` in the sort criteria (https://github.com/nystudio107/craft-similar/issues/32)

## 1.1.2 - 2021.03.23
### Fixed
* Fixed an SQL error related to even stricter GROUP BY rules.
* Fixed an error where using a tag field that had no matches on other elements could return a random set of entries. (https://github.com/nystudio107/craft-similar/issues/31)

## 1.1.1 - 2021.03.11
### Fixed
* Ensure that the key in `$similarCount` exists before referencing it

## 1.1.0 - 2021.03.05
### Added
* Added buildchain for docs

### Changed
* Similar elements are now fetched with the eager-loading conditions intact that were set on the criteria object. (https://github.com/nystudio107/craft-similar/issues/14)
* Similar elements are now searched in the source element site only by default.
* Similar plugin now requires at least Craft CMS 3.2.0.

### Fixed
* Fix an SQL error related to stricter GROUP BY rules. (https://github.com/nystudio107/craft-similar/issues/19)
* Fix an SQL error that could occur if no structure data was selected for entries. (https://github.com/nystudio107/craft-similar/issues/22)

## 1.0.6 - 2019-04-20
### Changed
* Add `structureelements.structureId` to `GROUP BY` clause

## 1.0.5 - 2019-01-05
### Changed
* Fix SQL error: Unknown column `structureelements.lft` in 'group statement for Products

## 1.0.4 - 2018-10-08
### Changed
* Only try to fetch elements if SQL query returns an `id`
* Update GROUP BY clause in SELECT queries to ensure they are compatible with `sql_mode=only_full_group_by`

## 1.0.3 - 2018-08-04
### Changed
* Fixed a regression of the returned query results

## 1.0.2 - 2018-07-21
### Changed
* Fixed an issue that errantly prefixed the sub-query with the table name

## 1.0.1 - 2018-07-21
### Changed
* Added grouping to the sub-query to ensure that it returns the correct number of results
* Moved the anonymous function `EVENT_AFTER_PREPARE` event handler to a named function to avoid serialization errors in cache tags
* Optimizations and code cleanup

## 1.0.0 - 2018-01-16
### Added
* Initial release
