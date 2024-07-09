<?php
    session_start();

    if(empty($_SESSION['user']['cart'])){
        $_SESSION['user']['cart'] = array();
    }

    if(empty($_SESSION['user']['cart'])) {
        header("Location: /shop/cart.php?error=Nothing in your cart to remove.");
        exit();
    } else if(!isset($_SESSION['user']['cart'][$_GET['index']])) {
        header("Location: /shop/cart.php?error=Couldn't find item index in your cart.");
        exit();
    }

    if (isset($_SESSION['user']['cart']) && isset($_GET['index'])) {
        $indexToRemove = $_GET['index'];

        if (array_key_exists($indexToRemove, $_SESSION['user']['cart'])) {
            unset($_SESSION['user']['cart'][$indexToRemove]);
            $_SESSION['user']['cart'] = array_values($_SESSION['user']['cart']);
        }
    }

    header("Location: /shop/cart.php?success=Successfully removed product from your cart.");
    exit();
?>