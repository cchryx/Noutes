<?php
    function db_findByUsername($username) {
        if(!empty($_SESSION['users'])) {
            if(!empty($_SESSION['users'][$username])) {
                return $_SESSION['users'][$username];
            } else {
                return null;
            }
        }
    }