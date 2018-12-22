<?php
header('Content-Type: application/json');
include "../db_tools/db_functions.php";
include "../validate/user_validation.php";
session_start();
validate_role($_SESSION["login_user"], "Instructor", "TA");
$conn = connect_db();
$content = json_decode($_GET["mark"], true);
$isRemark = isset($_GET["remark"]);
$userid = $content["userid"];
$workid = $content["workid"];
$mark = $content["mark"];
$result = array();
if ($userid != "" && $workid != "" && $mark != ""){
    if($isRemark){
        $isReq = deactive_request($conn, $userid, $workid);
        $result["result"] = $isReq && add_mark($conn, $userid, $workid, $mark);
    }else{
        $result["result"] = add_mark($conn, $userid, $workid, $mark);
    }
} else {
    $result["result"] = false;
}
echo json_encode($result);
close_db($conn);