<?php
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