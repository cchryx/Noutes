<?php
    session_start();

    $cart_items = count($_SESSION['user']['cart']);
    unset($_SESSION['user']['cart']);  

    header("Location: /shop/cart.php?success=Successfully cleared the car. ($cart_items)");
    exit();
?>