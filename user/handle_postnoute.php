<?php
    require '../data/database.php';

    session_start();

    // only post when there is a user logged in
    if (!isset($_SESSION['user'])) {
        header("Location: /onboarding/login.php");
        exit();
    }

    if(isset($_POST['title']) && isset($_POST['noute'])) {
        function validate($data){
           $data = trim($data);
           $data = htmlspecialchars($data);
           return $data;
        }
        
        $title = validate($_POST['title']);
        $noute = nl2br(validate($_POST['noute']));
        $image = validate($_POST['image']);

        if(empty($_SESSION['users'][$_SESSION['user']['username']]['noutes'])) {
            $_SESSION['users'][$_SESSION['user']['username']]['noutes'] = array();
        }

        if(empty($title)) {
            header("Location: home.php?error=Title can't be empty.");
            exit();
        } else if(empty($noute)) {
            header("Location: home.php?error=Noute can't be empty.");
            exit();
        } else {
            array_push($_SESSION['users'][$_SESSION['user']['username']]['noutes'], array(
                'title' => $title,
                'noute' => $noute,
                'image' => $image
            ));
            header("Location: home.php?success=Noute posted successfully.");
            exit();
        }

        
    }
?>

