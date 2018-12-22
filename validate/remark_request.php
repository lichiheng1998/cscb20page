<?php
header('Content-Type: application/json');
include "../db_tools/db_functions.php";
session_start();
$conn = connect_db();
$content = json_decode($_GET["user"], true);
$userid = $_SESSION["login_user"]["UserID"];
$workid = isset($content["workID"])?$content["workID"]:Null;
$description = isset($content["description"])?$content["description"]:Null;
$markerid = isset($content["markerID"])?$content["markerID"]:Null;
if($userid != "" && $workid != "" && $description != "" && $markerid != ""){
    $success = submitRemark($conn, $userid, $markerid, $workid, $description);
    if(!$success) {
        echo "Cannot add to database";
    }else{
        echo 'true';
    }
} else{
	echo "Missing info.";
}
close_db($conn)
?>
