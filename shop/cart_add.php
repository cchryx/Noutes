<?php
    session_start();

    if(empty($_SESSION['user']['cart'])){
        $_SESSION['user']['cart'] = array();
    }
    
    array_push($_SESSION['user']['cart'], $_GET['id']);    
    
    header("Location: /shop/products.php?success=Successfully added product to your cart.");
    exit();
?>