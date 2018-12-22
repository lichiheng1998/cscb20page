<?php
include "db_tools/db_functions.php";
include "validate/user_validation.php";
session_start();
$conn = connect_db();
$userAuth = $_SESSION["login_user"];
validate_role($userAuth, "Instructor", "TA");
$date = new DateTime();
$date -> setTimezone(new DateTimeZone('America/Toronto'));
$dateStr = $date -> format('Y-m-d');
$allRequest = getRemarkReq($conn);
$id = $userAuth["UserID"];
if(isset($allRequest[$id])){
    $myRequest = $allRequest[$id];
} else {
    $myRequest = array();
}
$otherRequest = array();
foreach($allRequest as $worker => $request){
    if($worker!= $id){
        foreach($allRequest[$worker] as $item){
            array_push($otherRequest, $item);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title></title>
</head>
<body>
<?php
echo file_get_contents("html_templates/header.html");
?>
<div id="main_block">
    <div id="main_page_body">
        <div id="request_date" class="new-component">
            <h2>Date of the Request</h2>
            <div class="row">Please selected the date of the remark requested: </div>
            <div class="row grid-2">
                <div class="col">
                    <div class="col"><input id="date" type="date"/></div>
                </div>
                <div class="col">
                    <input id="limit" type="number" placeholder="Limited to">
                </div>
            </div>
            <div class="center-button col tran" onclick="queryRemarkReq('<?php echo $id?>')">Show</div>
            <div id="hint" style="color: red;"></div>
        </div>
        <div id="myReq" class="new-component">
            <h2>Request to Me</h2>
            <?php
            if(count($myRequest) == 0){
                echo "<div style='color: red; font-size: x-small'>Currently no request to you.</div>";
            }
            ?>
        </div>
        <?php
        foreach($myRequest as $request){
            ?>
            <div class="component remarkreq">
                <h2>From <?php echo $request["StudentID"]?></h2>
                <div class="row grid-3">
                    <div class="col">WorkID</div>
                    <div class="col">CurrentMark</div>
                    <div class="col">NewMark</div>
                </div>
                <div class="row grid-3">
                    <div class="col"><?php echo $request["WorkID"]?></div>
                    <div class="col"><?php echo $request["Percentage"]?></div>
                    <div class="col row grid-2">
                        <form onsubmit="return false">
                            <input class="col" name="mark"
                                   step="0.01" required/>
                            <button class="col flat-button tran"
                                    onclick="updateMark(this,
                                    '<?php echo $request["StudentID"]?>',
                                    '<?php echo $request["WorkID"]?>')"
                            >
                                Update
                            </button>
                        </form>
                    </div>
                </div>
                <div class="hint"></div>
                <b>Reason</b>
                <div><?php echo $request["Description"]?></div>
                <div class="end-text">
                    Posted on <?php echo $request["UpdateDate"]?>
                </div>
            </div>
            <?php
        }
        ?>
        <div id="otherReq" class="new-component">
            <h2>Request to Others</h2>
            <?php
            if(count($otherRequest) == 0){
                echo "<div style='color: red; font-size: x-small'>Currently no request to others.</div>";
            }
            ?>
        </div>
        <?php
        foreach($otherRequest as $request){
            ?>
            <div class="component remarkreq">
                <h2>From <?php echo $request["StudentID"]?></h2>
                <div class="row grid-3">
                    <div class="col">WorkID</div>
                    <div class="col">CurrentMark</div>
                    <div class="col">NewMark</div>
                </div>
                <div class="row grid-3">
                    <div class="col"><?php echo $request["WorkID"]?></div>
                    <div class="col"><?php echo $request["Percentage"]?></div>
                    <div class="col row grid-2">
                        <form onsubmit="return false">
                            <input class="col" name="mark" type="number" step="0.01" required/>
                            <button class="col flat-button tran"
                                    onclick="updateMark(this,
                                        '<?php echo $request["StudentID"]?>',
                                        '<?php echo $request["WorkID"]?>')"
                            >
                                Update
                            </button>
                        </form>
                    </div>
                </div>
                <div class="hint"></div>
                <b>Reason</b>
                <div><?php echo $request["Description"]?></div>
                <div class="end-text">
                    Posted on <?php echo $request["UpdateDate"]?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    unset($allRequest);
    unset($myRequest);
    unset($otherRequest);
    echo file_get_contents("html_templates/footer.html");
    close_db($conn);
    ?>
</div>
</body>
<script src="js/main.js"></script>
<script src="js/manage_remark.js"></script>
</html>

