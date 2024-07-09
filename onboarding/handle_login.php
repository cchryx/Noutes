<?php
    require '../data/database.php';

    session_start(); 

    if(!empty($_SESSION['user'])) {
        header("Location: /user/home.php");
        exit();
    } else {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            // Keep fields in the form
            if(isset($_POST['username'])) {
                    $_SESSION['onboarding']['username'] = $_POST['username'];
            }
            function validate($data){
               $data = trim($data);
               $data = stripslashes($data);
               $data = htmlspecialchars($data);
               return $data;
            }

            $username = validate($_POST['username']);
            $password = validate($_POST['password']);

            if (empty($username)) {
                header("Location: login.php?error=Username is required.");
                exit();
            } else if(empty($password)){
                header("Location: login.php?error=Password is required.");
                exit();
            } else{
                $fetch_user = db_findByUsername($username);
                if ($fetch_user && $password === $fetch_user['password']) {
                    $_SESSION['user'] = $fetch_user;
                    header("Location: /user/home.php");
                    exit();
                } else {
                    header("Location: login.php?error=Incorect username or password.");
                    exit();
                }
            }
        } else {
            header("Location: login.php");
            exit();
        }
    }
?>

