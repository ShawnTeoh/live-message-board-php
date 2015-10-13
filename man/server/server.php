<?php
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
    include "../../shared/bot_db.php";
    set_time_limit(0);
    $data_source_file = 'data.txt';
    $timestamp = time();
    $force = 0;

    while (true) {
        $last_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        clearstatcache();
        $last_change_in_data_file = filemtime($data_source_file);
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, 'bot');

        if ($last_id == null || $last_change_in_data_file > $timestamp || $force) {
            if ($last_id == null) {
                $stmt = $mysqli->prepare("SELECT * FROM (SELECT id, name, msg, submit_time FROM man2015 ORDER BY id DESC LIMIT 5) sub ORDER BY id ASC");
            } else {
                $stmt = $mysqli->prepare("SELECT id, name, msg, submit_time FROM man2015 WHERE id > ? LIMIT 2");
                $stmt->bind_param("i", $last_id);
            }
            $retval = $stmt->execute();
            if ($retval) {
                $result = $stmt->get_result();
                $rows = array();
                while($r = mysqli_fetch_assoc($result)) {
                    $rows[] = $r;
                }
                foreach($rows as $key=>$val) {
                    $rows[$key]['name'] = stripslashes($val['name']);
                    $rows[$key]['msg'] = stripslashes($val['msg']);
                }
                $json = json_encode($rows);
                echo $json;
                $result->close();
            }
            $stmt->close();
            $mysqli->close();
            $force = 0;
            $timestamp = $last_change_in_data_file;
            break;
        } else {
            sleep(5);
            $result = $mysqli->query("SELECT * FROM man2015");
            $num_rows = $result->num_rows;
            if ($last_id != null) {
                $force = $last_id < $num_rows ? 1 : 0;
            }
            $mysqli->close();
            
            continue;
        }
    }
?>