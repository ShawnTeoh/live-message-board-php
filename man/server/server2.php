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

    $last_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    clearstatcache();

    if ($last_id > 1) {
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, 'bot');
        $stmt = $mysqli->prepare("SELECT * FROM (SELECT id, name, msg, submit_time FROM man2015 WHERE id < ? LIMIT ?, 10) sub ORDER BY id DESC");
        $offset = $last_id >= 10 ? $last_id - 10 : 0;
        $stmt->bind_param("ii", $last_id, $offset);
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
            sleep(2);
            echo $json;
            $result->close();
        }
        $stmt->close();
        $mysqli->close();
        $force = 0;
    } else {
        echo "[]";
    }
?>