<?php
header('content-type: application/json;charset=utf-8');
include "../db_tools/db_functions.php";
include "user_validation.php";
session_start();
$userAuth = $_SESSION["login_user"];
validate_role($userAuth, "Instructor", "TA");
$content = json_decode($_GET["query"], true);
$conn = connect_db();
echo json_encode(getRemarkReq($conn, $content["date"], $content["limit"]));
close_db($conn);
?>
