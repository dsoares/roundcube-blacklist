# Roundcube plugin blacklist

Roundcube plugin to provide a generic access blacklist.

The plugin can be configured to deny access to specific usernames, IPs, networks in CIDR notation or countries. It is not meant to be configured by users, only by the Roundcube Webmail administrator via configuration file.

This is a useful plugin when users's passwords have been caught by spammers, but the administrators can not change the users's passwords (only the user may change it's own password).

Stable versions of this plugin are available from the [Roundcube plugin repository][rcplugrepo] or the [releases section][releases] of the GitHub repository.


## Requirements

- [Roundcube plugin geolocation][rcpluggeolocation] if you configure to deny access by country.


## Installation

#### With composer

1. Go to your Roundcube root directory.

2. Run `$ composer require dsoares/blacklist`.

3. Copy `config.inc.php.dist` to `config.inc.php` and modify as necessary.


#### Manual Installation

Place this directory (named blacklist) under your Rouncdube `plugins/`
and enable blacklist plugin within the main Roundcube configuration file.

Copy `config.inc.php.dist` to `config.inc.php` and modify as necessary.

Please note that if you want to block access by country in the configuration file,
this plugin requires the [Roundcube plugin geolocation][rcpluggeolocation]
to be enabled and properly working.
Check the [geolocation][rcpluggeolocation] plugin instructions for more information.


## Configuration

- **$config['blacklist_usernames']** - `array` of usernames to deny access.

- **$config['blacklist_ips']** - `array` of IPs and networks in CIDR notation to deny access.

- **$config['blacklist_countries']** - `array` of countries to deny access.

- **$config['blacklist_log']** - `boolean`, if the plugin should log denied requests.


## License

This plugin is released under the [GNU General Public License Version 3+][gpl].

## Contact

Comments and suggestions are welcome!

Email: [Diana Soares][dsoares]

[rcplugrepo]: https://plugins.roundcube.net/packages/dsoares/blacklist
[releases]: https://github.com/dsoares/roundcube-blacklist/releases
[rcpluggeolocation]: https://plugins.roundcube.net/packages/dsoares/geolocation
[gpl]: https://www.gnu.org/licenses/gpl.html
[dsoares]: mailto:diana.soares@gmail.com
