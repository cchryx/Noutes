<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        // Check if there is something in the query string
        if (!empty($_SERVER['QUERY_STRING'])) {
            // Generate JavaScript to wait for 10 seconds and then clear the query string
            echo '<script>';
            echo 'setTimeout(function() {';
            echo '    window.history.replaceState({}, document.title, "' . $_SERVER['PHP_SELF'] . '");';
            echo '}, 10000);'; // 10000 milliseconds = 10 seconds
            echo '</script>';
        }
?>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/style.css" />
        <link rel="stylesheet" href="./onboarding.css" />
    
        <title>Noutes | Signup</title>
    </head>
    
    <body>
        <?php include '../components/landing_header.php' ?>
        <div class="body_container">
            <div class="onboarding_container">
                <form method="post" action="handle_signup.php">
                    <div class="onboarding_box">
                        <div class="onboarding_header">
                            <h1 class="header-text">Signup</h1>
                        </div>
                        <?php if (isset($_GET['error'])) { ?>
                            <div class="form_error"><?php echo $_GET['error']; ?></div>
                        <?php } ?>
                        <div class="onboarding_form">
                            <label for="fullname"><b>Full Name</b></label>
                            <input 
                                type="text" 
                                placeholder="Enter Full Name" 
                                name="fullname"
                                value="<?php if (isset($_SESSION['onboarding']['fullname'])) { ?><?php if ($_SESSION['onboarding']['fullname'] != null) { ?><?php echo $_SESSION['onboarding']['fullname']; ?><?php } ?><?php } ?>"
                            >

                            <label for="username"><b>Username</b></label>
                            <input 
                                type="text" 
                                placeholder="Enter Username" 
                                name="username"
                                value="<?php if (isset($_SESSION['onboarding']['username'])) { ?><?php if ($_SESSION['onboarding']['username'] != null) { ?><?php echo $_SESSION['onboarding']['username']; ?><?php } ?><?php } ?>"
                            >
    
                            <label for="email"><b>Email</b></label>
                            <input 
                                type="text" 
                                placeholder="Enter Email" 
                                name="email"
                                value="<?php if (isset($_SESSION['onboarding']['email'])) { ?><?php if ($_SESSION['onboarding']['email'] != null) { ?><?php echo $_SESSION['onboarding']['email']; ?><?php } ?><?php } ?>"
                            >

                            <label for="birthdate"><b>Birthdate</b></label>
                            <input 
                                type="date" 
                                name="birthdate"
                                value="<?php if (isset($_SESSION['onboarding']['birthdate'])) { ?><?php if ($_SESSION['onboarding']['birthdate'] != null) { ?><?php echo $_SESSION['onboarding']['birthdate']; ?><?php } ?><?php } ?>"
                            >
    
                            <label for="password"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" name="password">
    
                            <div class="buttons_container">
                                <button type="submit" name="submit">Signup</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
    
    </html>
<?php
    } else {
        header("Location: /user/home.php");
        exit();
    }
?>

