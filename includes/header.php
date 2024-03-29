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
		header("Location: /slotify_app/admin/admin.php");
	}
	echo "<script>userLoggedIn = '$username';</script>";
}
else {
	header("Location: register.php");
}

?>

<html>
<head>
	<title>NAH05</title>
	<link rel="stylesheet" type="text/css" href="/slotify_app/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="/slotify_app/assets/css/register.css">
	<link rel="stylesheet" type="text/css" href="/slotify_app/assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="/slotify_app/assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="/slotify_app/assets/css/header.css">
	<link rel="stylesheet" type="text/css" href="/slotify_app/assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/slotify_app/assets/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="/slotify_app/assets/slick/slick-theme.css"/>
	<link rel="icon" href="/slotify_app/assets/images/logomain.jpg">
	<script src="/slotify_app/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="/slotify_app/assets/js/script.js"></script>
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

		.search-list li span {
			color: rgba(255,255,255,0.8);
		}

		.search-list li span:hover {
			color: black;
			cursor: pointer;
		}
	</style>
</head>

<body>
	<header id="header">
		<div class="header__top-bar">
			<div class="header__top-bar-inner">
				<a href="browse.php">
					<img src="/slotify_app/assets/images/logomain.jpg" class="logo-login" alt="">
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
								<img src="/slotify_app/assets/images/profile-pics/head_emerald.png" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="z-menu-bar">
				<div class="z-menu-bar-inner">
					<ul class="z-nav pri">
						<li class="z-shrink">
							<span onclick=openPage("browse.php") class="nav-link text-upper">Trang chủ</span>
						</li>
						<li>
							<span onclick=openPage("top100.php") class="nav-link text-upper">Top 100</span>
						</li>
						<li>
							<span onclick=openPage("titleAll.php") class="nav-link text-upper">Chủ đề</span>
						</li>
						<li>
							<span onclick=openPage("albumAll.php") class="nav-link text-uppe">Album</span>
						</li>
						<li>
							<span onclick=openPage("yourMusic.php") class="nav-link text-upper">Your Playlist</span>
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