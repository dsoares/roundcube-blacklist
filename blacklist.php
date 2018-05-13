<?php
/**
 * Roundcube plugin blacklist
 *
 * Roundcube plugin to provide a generic access blacklist.
 *
 * @version 0.1.1
 * @author Diana Soares
 * @requires geolocation
 *
 * Copyright (C) 2016-2018 Diana Soares
 *
 * This program is a Roundcube (http://www.roundcube.net) plugin.
 * For more information see README.md.
 * For configuration see config.inc.php.dist.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Roundcube. If not, see http://www.gnu.org/licenses/.
 */

class blacklist extends rcube_plugin
{
    public $task = 'login';

    /**
     * Plugin initialization.
     */
    public function init()
    {
        $this->require_plugin('geolocation');
        $this->add_hook('authenticate', array($this, 'authenticate'));
    }

    /**
     * Hook authenticate: check if the login attempt is blacklisted.
     */
    public function authenticate($args)
    {
        $this->load_config();
        $rcmail = rcmail::get_instance();

        foreach (array('usernames', 'ips', 'countries') as $i) {
            $blacklist[$i] = $rcmail->config->get('blacklist_'.$i, array());
        }

        $username = $args['user'];
        $ip = $country = '';

        if (!in_array($username, $blacklist['usernames'])) {
            $ip = rcube_utils::remote_addr();

            if (!in_array($ip, $blacklist['ips'])) {
                $geo = geolocation::get_instance()->get_geolocation($ip);

                if ($geo === false or is_string($geo)
                    or !in_array($geo['country'], $blacklist['countries'])) {
                    return $args;
                }

                $country = (is_array($geo) ? $geo['country'] : '');
            }
        }

        if ($rcmail->config->get('blacklist_log', true)) {
            rcube::write_log('userlogins',
                sprintf('Login for %s%s%s denied by blacklist', $username,
                    ($ip ? sprintf(' from %s', $ip) : ''),
                    ($country ? sprintf(' (%s)', $country) : '')
            ));
        }

        $args['abort'] = true;
        return $args;
    }
}
