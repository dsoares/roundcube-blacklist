<?php
/**
 * Roundcube plugin blacklist
 *
 * Roundcube plugin to provide a generic access blacklist.
 *
 * @version 0.1.3
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

        if ($blacklist['countries']) {
            $this->require_plugin('geolocation');
        }

        $username = $args['user'];
        $ip = $country = '';

        if (!in_array($username, $blacklist['usernames'])) {
            $ip = rcube_utils::remote_addr();

            foreach ($blacklist['ips'] as $cidr) {
                if ($this->cidr_match($ip, $cidr)) {
                    break;
                }
            }

            $geo = !empty($blacklist['countries'])
                ? geolocation::get_instance()->get_geolocation($ip) : false;

            if ($geo === false or is_string($geo)
                or !in_array($geo['country'], $blacklist['countries'])) {
                return $args;
            }

            $country = (is_array($geo) ? $geo['country'] : '');
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

    /**
     * Check the client IP against a value in CIDR notation.
     */
    private function cidr_match($ip, $cidr)
    {
        if (strpos($cidr, '/') === false) {
            $cidr .= '/32';
        }

        list($subnet, $bits) = explode('/', $cidr);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
        return ($ip & $mask) == $subnet;
    }
}
