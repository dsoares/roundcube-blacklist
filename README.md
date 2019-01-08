# Roundcube plugin blacklist

Roundcube plugin to provide a generic access blacklist.

The plugin can be configured to deny access to specific usernames, IPs or countries. It is not meant to be configured by users, only by the Roundcube Webmail administrator via configuration file.

This is a useful plugin when users's passwords have been caught by spammers, but the administrators can not change the users's passwords (only the user may change it's own password).

Stable versions of this plugin are available from the [Roundcube plugin repository][rcplugrepo] (for 1.0 and above) or the [releases section][releases] of the GitHub repository.

## Requirements

- [Roundcube plugin geolocation][rcpluggeolocation]


## Installation

#### With composer

Add the plugin to your `composer.json` file:

    "require": {
        (...)
        "dsoares/blacklist": ">=0.1"
    }

And run `$ composer update [--your-options]`.

Copy `config.inc.php.dist` to `config.inc.php` and modify as necessary.

#### Manual Installation

Place this directory under your Rouncdube `plugins/` and enable blacklist
plugin within the main Roundcube configuration file.

Copy `config.inc.php.dist` to `config.inc.php` and modify as necessary.

Please note that this plugin requires the [Roundcube plugin geolocation][rcpluggeolocation]
to be enabled and properly working if you add any country to the blacklist.
Check the [geolocation][rcpluggeolocation] plugin instructions for more information.

## Configuration

- **$config['blacklist_usernames']** - `array` of usernames to deny access.

- **$config['blacklist_ips']** - `array` of IPs to deny access.

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
