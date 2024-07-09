<?php
    require '../data/database.php';

    session_start();

    if(!empty($_SESSION['user'])) {
        header("Location: /user/home.php");
        exit();
    } else {
        if(isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
            // Keep fields in the form
            if(isset($_POST['fullname'])) {
                    $_SESSION['onboarding']['fullname'] = $_POST['fullname'];
            }
            if(isset($_POST['username'])) {
                    $_SESSION['onboarding']['username'] = $_POST['username'];
            }
            if(isset($_POST['email'])) {
                    $_SESSION['onboarding']['email'] = $_POST['email'];
            }
            if(isset($_POST['birthdate'])) {
                    $_SESSION['onboarding']['birthdate'] = $_POST['birthdate'];
            }

            function validate($data){
               $data = trim($data);
               $data = stripslashes($data);
               return $data;
            }

            function containsOnlyValidCharacters($inputString) {
                $pattern = '/^[A-Za-z0-9_.]+$/';
                return preg_match($pattern, $inputString) === 1;
            }

            $fullname = validate($_POST['fullname']);
            $username = validate($_POST['username']);
            $email = validate($_POST['email']);
            $password = validate($_POST['password']);
            $birthdate = validate($_POST['birthdate']);


            if (empty($fullname)) {
                header("Location: signup.php?error=Full Name is required.");
                exit();
            } else if(empty($username)){
                header("Location: signup.php?error=Username is required.");
                exit();
            } else if(empty($email)){
                header("Location: signup.php?error=Email is required.");
                exit();
            } else if(empty($password)){
                header("Location: signup.php?error=Password is required.");
                exit();
            } else if(empty($birthdate)){
                header("Location: signup.php?error=Birthdate is required.");
                exit();
            } else if (strlen($fullname) > 20) {
                header("Location: signup.php?error=Max fullname length 20 characters.");
                exit();
            } else if (strlen($username) > 20) {
                header("Location: signup.php?error=Max username length 20 characters.");
                exit();
            } else if (strlen($email) > 50) {
                header("Location: signup.php?error=Max email length 50 characters.");
                exit();
            } else if (strlen($password) > 50) {
                header("Location: signup.php?error=Max password length 50 characters.");
                exit();
            } else if (!containsOnlyValidCharacters($username)) {
                header("Location: signup.php?error=Username can only contain letters, numbers, '.', and '_'.");
                exit();
            } else {
                if(!empty(db_findByUsername($username))) {
                    header("Location: signup.php?error=Username is already taken.");
                    exit();
                } else {
                    $_SESSION['users'][$username]['fullname'] = $fullname;
                    $_SESSION['users'][$username]['username'] = $username;
                    $_SESSION['users'][$username]['email'] = $email;
                    $_SESSION['users'][$username]['birthdate'] = $birthdate;
                    $_SESSION['users'][$username]['password'] = $password;

                    $fetch_user = db_findByUsername($username);
                    $_SESSION['user'] = $fetch_user;                
                    header("Location: /user/home.php");
                    exit();
                }
            }
        } else {
            header("Location: login.php");
            exit();
        }
    } 
?>

