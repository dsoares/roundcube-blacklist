Roundcube Plugin Blacklist
==========================

Roundcube plugin to provide a generic access blacklist.

The plugin can be configured to deny access to specific usernames, IPs or countries. It is not meant to be configured by users, only by the Roundcube Webmail administrator via configuration file.

This is a useful plugin when users's passwords have been caught by spammers, but the administrators can not change the users's passwords (only the user may change it's own password).

**NOTE:**

This is just a snapshot from the GIT repository and **MAY NOT BE A STABLE version of Blacklist**. It is Intended for use with the **GIT-master** version of Roundcube and it may not be compatible with older versions.
Stable versions of Blacklist are available from the [Roundcube plugin repository][rcplugrepo] (for 1.0 and above) or the [releases section][releases] of the GitHub repository.

Requirements
------------

- [Roundcube Plugin Geolocation][rcpluggeolocation]


Installation with composer
----------------------------------------

Add the plugin to your `composer.json` file:

    "require": {
        (...)
        "dsoares/blacklist": ">=0.1"
    }

And run `$ composer update [--your-options]`.

Manual Installation
----------------------------------------

Place this directory under your Rouncdube `plugins/` and enable blacklist
plugin within the main Roundcube configuration file.

Copy `config.inc.php.dist` to `config.inc.php` and modify as necessary.

Please note that this plugin requires the [Roundcube Plugin Geolocation][rcpluggeolocation] to be enabled and properly working. Check the plugin instructions for more information.

Configuration
----------------------------------------

- **$config['blacklist_usernames']** - `array` of usernames to deny access.

- **$config['blacklist_ips']** - `array` of IPs to deny access.

- **$config['blacklist_countries']** - `array` of countries to deny access.

- **$config['blacklist_log']** - `boolean`, if the plugin should log denied requests.


License
----------------------------------------

This plugin is released under the [GNU General Public License Version 3+][gpl].

Contact
----------------------------------------

Comments and suggestions are welcome!

Email: [Diana Soares][dsoares]

[rcplugrepo]: http://plugins.roundcube.net/packages/dsoares/blacklist
[releases]: http://github.com/JohnDoh/Roundcube-Plugin-Blacklist/releases
[rcpluggeolocation]: http://github.com/dsoares/Roundcube-Plugin-Geolocation
[gpl]: http://www.gnu.org/licenses/gpl.html
[dsoares]: mailto:diana.soares@gmail.com
