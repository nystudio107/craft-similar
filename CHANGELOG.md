# Similar Changelog

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
