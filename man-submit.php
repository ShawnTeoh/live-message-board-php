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
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Confirmation Page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.1/flatly/bootstrap.min.css" />
</head>
<body>
<div class="jumbotron">
<div class="container">
<p><img class="img-responsive" src="images/logo.png" alt="logo"/></p>
<?php
    include "shared/common.php";
    include "shared/bot_db.php";
    $show_error_msg = true;

    function check_vars() {
        if (!isset($_SESSION["token"]) || !isset($_POST["veri"]) || $_POST["veri"] != $_SESSION["token"]) {
            echo "<p>Did you accidentally refresh or mistakenly entered this page?</p>";
            global $show_error_msg;
            $show_error_msg = false;
            return false;
        }
        $a = array("name", "msg");
        foreach ($a as $value) {
            if (!array_key_exists($value, $_POST)) {
                echo "<p>Missing variables!</p>";
                return false;
            } else {
                if (empty($_POST[$value])) {
                    echo "<p>Empty variables!</p>";
                    return false;
                }
            }
        }

        return true;
    }

    if (check_vars()) {
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, 'bot');
        $stmt = $mysqli->prepare('INSERT INTO man2015 (name, msg, submit_time, ip, ua) '.
                                 'VALUES (?, ?, NOW(), ?, ?)');
        $_name = $mysqli->real_escape_string($_POST["name"]);
        $tmpmsg = str_replace(array("\r\n", "\n\r", "\r", "\n"), "", nl2br($_POST["msg"]));
        $_msg = $mysqli->real_escape_string($tmpmsg);
        $_ip = $mysqli->real_escape_string(ip());
        $_ua = $mysqli->real_escape_string(ua());
        $stmt->bind_param("ssss", $_name, $_msg, $_ip, $_ua);
        $retval = $stmt->execute();
        $stmt->close();

        if (!$retval) {
            echo "<p>Something went wrong, please contact UQMSA. (Database error)</p>";
        } else {
            session_unset();
            session_destroy();
            file_put_contents("man/server/data.txt", time());
            echo "<p>Done!</p>";
        }
        $mysqli->close();
    } else {
        if ($show_error_msg) {
            echo "<p>Something went wrong, please contact UQMSA.</p>";
        }
    }
?>
<p><a class="btn btn-primary btn-lg" href="http://www.uqmsa.org" role="button">Go back to home page</a></p>
</div>
</div>
<footer>
<div class="container">
<a href="https://www.positivessl.com" style="font-family: arial; font-size: 10px; color: #212121; text-decoration: none;"><img src="https://www.positivessl.com/images-new/PositiveSSL_tl_trans.png" alt="SSL Certificate" title="SSL Certificate" border="0" /></a><div style="font-family: arial;font-weight:bold;font-size:15px;color:#86BEE0;"><a href="https://www.positivessl.com" style="color:#86BEE0; text-decoration: none;">SSL Certificate</a></div>
</div>
</footer>
</body>
</html>
