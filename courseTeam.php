<?php
include 'db_tools/db_functions.php';
include 'validate/user_validation.php';
session_start();
$userAuth = $_SESSION["login_user"];
$conn = connect_db();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
	</head>
	<body>
		<?php
		echo file_get_contents("html_templates/header.html");
		?>
		<div id="main_block">
			<div id="main_page_body">
				<section class="component">
					<h2>Currently Logged in: <?php echo $userAuth["UserID"]?>
						(<?php echo $userAuth["Role"]?>)
					</h2>
					<?php
					switch($userAuth["Role"]){
						case "Student":
							echo file_get_contents("html_templates/student_nav.html");
							break;
						case "TA":
							echo file_get_contents("html_templates/ta_nav.html");
							break;
						case "Instructor":
							echo file_get_contents("html_templates/instructor_nav.html");
							break;
					}
					?>
				</section>
				<div class="component">
					<h2>
						Professor
					</h2>
					<div class="row grid-2">
						<div class="col1">
							<img src="img/profile.png" height="80%", width="80%">
						</div>
						<div class="col2">
							<p>Instructor: Abbas Attarwala</p>
							<p>Email: abbas.attarwala@utoronto.ca</p>
							<p>Office: IC478</p>
							<p>Office hour: Monday 11:30 - 13:30
                            <p><span id="tab">Friday: 11:30 - 13:30</span></p>
						</div>
					</div>
				</div>
				<div class="component">
					<h2>
						TA
					</h2>
					<div class="row grid-2">
						<div class="col1">
							<img src="img/profile.png" height="80%", width="80%">
						</div>
						<div class="col2">
							<p>Instructor: Nagarjun</p>
							<p>Email: nagarjun.ratnesh@mail.utoronto.ca</p>
							<p>Office: IC404</p>
							<p>Office hour:Tuesday 9:00 - 12:00</p>
						</div>
					</div>
					<br>
					<div class="row grid-2">
						<div class="col1">
							<img src="img/profile.png" height="80%", width="80%">
						</div>
						<div class="col2">
							<p>Instructor: Zhongyang</p>
							<p>Email: zhongyang.xia@mail.utoronto.ca</p>
							<p>Office: IC404</p>
							<p>Office hour: Friday 13:00- 16:00</p>
						</div>
					</div>
					<br>
					<div class="row grid-2">
						<div class="col1">
							<img src="img/profile.png" height="80%", width="80%">
						</div>
						<div class="col2">
							<p>Instructor: Syeda</p>
							<p>Email:</p>
							<p>Office: IC404</p>
							<p>Office hour: Thursday 11:00-12:00</p>
							<p><span>Friday 15:00 to 17:00</span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="footer-tag">
			    <div class="left-float">
		    		<div class="grow-small">
		    			<a href="http://web.cs.toronto.edu/">Faculty of Computer Science at UofT</a>
		    		</div>
			
			    	<p>Copyright © 2018 Site Design by Chiheng Li and Nicole Xin Yue Wang</p>
			    </div>
			    <div class="right-float">
			    	<p><b>email: </b>chiheng.li@mail.utoronto.ca</p>
			    	<p>and nicoletut.wang@mail.utoronto.ca </p>
			    </div>
			</div>
		</div>
	</body>
	<script src="js/main.js"></script>
</html>
