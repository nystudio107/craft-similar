# Similar Changelog

All notable changes to this project will be documented in this file.

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
