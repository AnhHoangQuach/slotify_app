<?php
    include("includes/includedFiles.php");
?>

<div class="entityInfo">
    <div class="centerSection">
        <div class="user-avatar">
            <img src="/slotify_app/assets/images/profile-pics/head_emerald.png" alt="">
        </div>
        <div class="userInfo text-center">
            <h1><?php echo $userLoggedIn->getFullname(); ?></h1>
        </div>
        <ul class="button-menu">
            <li onclick="openPage('updateDetails.php');"><span>User Details</span></li>
            <li onclick="logout()"><span>Log out</span></li>
        </ul>
    </div>
</div>