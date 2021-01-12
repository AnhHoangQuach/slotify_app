<?php
include("config.php");
include("classes/Artist.php");
include("classes/Album.php");
include("classes/Song.php");
include("classes/User.php");
include("classes/Playlist.php");

//session_destroy(); LOGOUT

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = new User($con,  $_SESSION['userLoggedIn']);
	$username = $userLoggedIn->getUsername();
	$role = $userLoggedIn->getRole();
	if($role == 1) {
		header("Location: ../admin/admin.php");
	}
	echo "<script>userLoggedIn = '$username';</script>";
}
else {
	header("Location: register.php");
}

?>

<html>
<head>
	<title>Welcome to Slotify!</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/register.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/header.css">
	<link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="../assets/slick/slick-theme.css"/>
	<link rel="icon" href="../assets/images/icons/logoicon.jpg">
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="../assets/js/script.js"></script>
	<style>
		#result_index {
            position: absolute;
			font-size: 12px;
            top: 40px;
            width: 100%;
            background-color: rgba(106, 57, 175, 1);
            border-radius: 5px;
        }
		#result_index .search-list {
			display: flex;
			justify-content: space-between;
			padding: 10px;
		}

		.search-list li a {
			color: rgba(255,255,255,0.8);
		}

		.search-list li a:hover {
			color: black;
		}
	</style>
</head>

<body>
	<header id="header">
		<div class="header__top-bar">
			<div class="header__top-bar-inner">
				<a href="browse.php">
					<img src="../assets/images/logomain.jpg" class="logo-login" alt="">
				</a>
				<div class="header__menu-bar-search">
					<form action="">
						<div class="z-input-group header-search-group">
							<label for="">
								<i class="icon ic-search"></i>
							</label>
							<div class="input-wrapper">
								<input id="input_result" type="text" placeholder="Nhập tên bài hát, ca sĩ, album..." class="form-control">
							</div>
							<div id="result_index"></div>
						</div>
					</form>
				</div>
				<div class="header__menu-user-profile">
					<a class="icon-button z-center mar-left-10">
						<i class="icon ic-upload"></i>
					</a>
					<div class="z-noti-wrap">
						<a href="" class="icon-button z-center mar-left-10">
							<i class="icon ic-noti"></i>
						</a>
					</div>
					<div class="z-login-wrap pull-right mar-left-10">
						<div class="z-card card-40">
							<div class="thumb-40" onclick="openPage('settings.php')">
								<img src="/assets/images/profile-pics/head_emerald.png" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="z-menu-bar">
				<div class="z-menu-bar-inner">
					<ul class="z-nav pri">
						<li class="z-shrink">
							<a href="./browse.php" class="nav-link text-upper <?php if($_SERVER['SCRIPT_NAME'] == "/browse.php") echo "active" ?>">Trang chủ</a>
						</li>
						<li>
							<a href="./top100.php" class="nav-link text-upper  <?php if($_SERVER['SCRIPT_NAME'] == "/top100.php") echo "active" ?>">Top 100</a>
						</li>
						<li>
							<a href="./titleAll.php" class="nav-link text-upper  <?php if($_SERVER['SCRIPT_NAME'] == "/titleAll.php") echo "active" ?>">Chủ đề</a>
						</li>
						<li>
							<a href="./albumAll.php" class="nav-link text-upper <?php if($_SERVER['SCRIPT_NAME'] == "/albumAll.php") echo "active" ?>">Album</a>
						</li>
						<li>
							<a href="./yourMusic.php" class="nav-link text-upper  <?php if($_SERVER['SCRIPT_NAME'] == "/yourMusic.php") echo "active" ?>">Your Playlist</a>
						</li>
					</ul>
				</div>	
			</div>
		</div>
		<script>
            $(document).ready(function(){
                load_data();
                function load_data(query) {
                    $.ajax({
                        url:"search.php",
                        method:"post",
                        data:{query:query},
                        success:function(data)
                        {
                            $('#result_index').html(data);
                        }
                    });
                }
                
                $('#input_result').keyup(function(){
                    var search = $(this).val();
                    if(search != '') {
                        load_data(search);
                    } else {
                        load_data();			
                    }
                });
            });
        </script>
	</header>

	<main class="bg-page" id="mainContent">