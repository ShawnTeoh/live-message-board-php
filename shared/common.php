/*
 * Copyright (C) 2015 Thuan Song Teoh
 *
 * This file is part of live-message-board-php.
 *
 * live-message-board-php is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
<?php
    function ip() {
        if (isset($_SERVER)) {
            if(isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_FORWARDED_FOR'];
            } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP' );
            } elseif (getenv('HTTP_FORWARDED_FOR')) {
                $ip = getenv('HTTP_FORWARDED_FOR');
            } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }
        return $ip;
    }

    function ua() {
        if(stristr($_SERVER['HTTP_USER_AGENT'], 'Opera Mini')) {
            if(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) {
                $browser = addslashes(strip_tags($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']));
            } else {
                $browser = addslashes(strip_tags($_SERVER['HTTP_USER_AGENT']));
            }
        } else {
            $browser = addslashes(strip_tags($_SERVER['HTTP_USER_AGENT']));
        }
        return $browser;
    }
?>