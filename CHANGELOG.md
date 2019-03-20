# Changelog

All notable changes to `github-deploy-key` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](https://keepachangelog.com) principles.

## [Unreleased]

## [v1.2.1] - 2019-03-20

### Fixed
- Fix Travis Phar release uploading to use PHP 7.2 ([a8fbfad3](a8fbfad38b0c41ae59ef8872c7be2b3fb591d764)
- Add version replacement to remove mismatches ([280ec469](280ec4694303a310826a988b1aa843c2b1450096)

## [v1.2.0] - 2019-03-20

### Added
- Add support for PHPUnit 8 ([#9](https://github.com/pxgamer/github-deploy-key/pull/9))

### Changed
- Update the directory structure ([#10](https://github.com/pxgamer/github-deploy-key/pull/10))

## [v1.1.4] - 2018-11-13

### Changed
- Update to use automated Phar releases using Travis

## [v1.1.3] - 2018-01-09

### Added
- Add Box support

## [v1.1.2] - 2017-12-06

### Fixed
- Fix the legal name in license

## [v1.1.1] - 2017-11-20

### Fixed
- Fix the format of the license file

## [v1.1.0] - 2017-11-09

### Added
- Update the format for the README
- Add more testing data
- Add community files
- Update to require PHP ^7.1

## [v1.0.2] - 2017-08-08

### Added
- Add TravisCI YML
- Create the first test
- Add a PhpUnit config

### Removed
- Remove HHVM support
- Remove support for less than PHP 7.1

## [v1.0.1] - 2017-08-08

### Added
- Add multiple PhpDocs for the AddCommand class
- Change `--token` to be a REQUIRED value
- Remove symfony/filesystem requirement as it's not being used.
- Update README to include example and usage

## v1.0.0 - 2017-08-08

### Added
- Initial full command flow

[Unreleased]: https://github.com/pxgamer/github-deploy-key/compare/master...develop
[v1.2.1]: https://github.com/pxgamer/github-deploy-key/compare/v1.2.0...v1.2.1
[v1.2.0]: https://github.com/pxgamer/github-deploy-key/compare/v1.1.4...v1.2.0
[v1.1.4]: https://github.com/pxgamer/github-deploy-key/compare/v1.1.3...v1.1.4
[v1.1.3]: https://github.com/pxgamer/github-deploy-key/compare/v1.1.2...v1.1.3
[v1.1.2]: https://github.com/pxgamer/github-deploy-key/compare/v1.1.1...v1.1.2
[v1.1.1]: https://github.com/pxgamer/github-deploy-key/compare/v1.1.0...v1.1.1
[v1.1.0]: https://github.com/pxgamer/github-deploy-key/compare/v1.0.2...v1.1.0
[v1.0.2]: https://github.com/pxgamer/github-deploy-key/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/pxgamer/github-deploy-key/compare/v1.0.0...v1.0.1
