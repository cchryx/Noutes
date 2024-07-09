<?php
    require '../data/database.php';

    session_start();

    // only post when there is a user logged in
    if (!isset($_SESSION['user'])) {
        header("Location: /onboarding/login.php");
        exit();
    }

    if (!isset($_GET['editsetting']) || !isset($_POST)) {
        header("Location: /user/home.php");
        exit();
    }

    function validate($data) {
       $data = trim($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    
    $editsetting = $_GET['editsetting'];
    $editsetting_value = $_POST[$editsetting];
    $userData = $_SESSION['users'][$_SESSION['user']['username']];

    if($editsetting === "password" && $_POST[$editsetting."_old"] != $userData[$editsetting]) {
        header("Location: settings.php?error=Password didn't change, wrong old password.");
        exit();
    }

    if($editsetting === "username") {
        header("Location: settings.php?error=Can't change username.");
        exit();
    }

    if($editsetting === "username" && !empty(db_findByUsername($editsetting_value))) {
        header("Location: settings.php?error=Username didn't change, username is already taken.");
        exit();
    }

    // limit lengths
    if($editsetting === "fullname" && strlen($editsetting_value) > 20) {
       header("Location: settings.php?error=Max fullname length 20 characters.");
       exit();
    }
    // if($editsetting === "username" && strlen($editsetting_value) > 20) {
    //    header("Location: settings.php?error=Max username length 20 characters.");
    //    exit();
    // }
    if($editsetting === "email" && strlen($editsetting_value) > 50) {
       header("Location: settings.php?error=Max email length 50 characters.");
       exit();
    }
    if($editsetting === "password" && strlen($editsetting_value) > 50) {
       header("Location: settings.php?error=Max password length 50 characters.");
       exit();
    }  

    
    $_SESSION['users'][$_SESSION['user']['username']][$editsetting] = $editsetting_value;
    $fetch_user = db_findByUsername($userData['username']);
    $_SESSION['user'] = $fetch_user;


    header("Location: settings.php?success=Successfully changed your $editsetting.");
    exit();
    
    
?>

