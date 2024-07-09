<?php
    session_start();

    if (isset($_SESSION['user'])) {
        // Check if there is something in the query string
        // if (!empty($_SERVER['QUERY_STRING'])) {
        //     // Generate JavaScript to wait for 10 seconds and then clear the query string
        //     echo '<script>';
        //     echo 'setTimeout(function() {';
        //     echo '    window.history.replaceState({}, document.title, "' . $_SERVER['PHP_SELF'] . '");';
        //     echo '}, 10000);'; // 10000 milliseconds = 10 seconds
        //     echo '</script>';
        // }
?>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" href="/user/user.css" />
        
        <title>Noutes | Settings</title>
    </head>

    <body>
        <?php if (isset($_GET['editsetting'])) { ?>    
            <div class="lightbox_container" id="lightbox_container" style="display: flex;">
                <div class="close_container" onclick="unlightbox()">
                    <a href="/user/settings.php" >
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <div class="editsetting_container">
                    <form method="post" action="handle_editsetting.php?editsetting=<?php echo $_GET['editsetting']; ?>">
                        <h3 class="font_aquire">Change <?php echo $_GET['editsetting']; ?></h3>
                        <hr />
                         <?php
                             if(isset($_GET['editsetting']) && $_GET['editsetting'] === "password") {
                                 echo '<input class="editsetting_field" name="' . $_GET['editsetting'] . '_old" placeholder="Old ' . $_GET['editsetting'] . '"/>';
                             }
                         ?>
                        <input class="editsetting_field" name="<?php echo $_GET['editsetting']; ?>" placeholder="New <?php echo $_GET['editsetting']; ?>"/>
                        <div class="buttons_container">
                            <button type="submit" name="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
        <?php include '../components/user_navbar.php' ?>
        <div class="navbar_toggle" id="navbar_toggle" onclick="togglenavbar()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="body_container">
            <div class="body_wrapper">
                <div class="settings_container">
                    <div class="settings_wrapper">
                        <h3 class="font_aquire">Settings</h3>
                        <hr />
                        <div class="settings_body">
                            <?php if (isset($_GET['error'])) { ?>    
                                <div class="form_error"><?php echo $_GET['error']; ?></div>
                            <?php } ?>
                            <?php if (isset($_GET['success'])) { ?>
                                <div class="form_success"><?php echo $_GET['success']; ?></div>
                            <?php } ?>
                            <table>
                                <tr>
                                    <td><h4>Fullname: </h4><p><?php echo $_SESSION['user']['fullname'];?></p></td>
                                    <td><a href="?editsetting=fullname">Change fullname</a></td>
                                </tr>
                                <tr>
                                    <td><h4>Username: </h4><p><?php echo $_SESSION['user']['username'];?></p></td>
                                    <td>
                                        <!-- <a href="?editsetting=username">Change username</a> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td><h4>Email: </h4><p><?php echo $_SESSION['user']['email'];?></p></td>
                                    <td><a href="?editsetting=email">Change email</a></td>
                                </tr>
                                <tr>
                                    <td><h4>Password: </h4><p>[HIDDEN]</p></td>
                                    <td><a href="?editsetting=password">Change password</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const navbar_toggle = document.getElementById("navbar_toggle");

            if (window.innerWidth <= 768) {
                navbar_toggle.style.display = "flex"
            }
            window.addEventListener('resize', function(event) {
                if (window.innerWidth <= 768) {
                    navbar_toggle.style.display = "flex"
                } else {
                    navbar_toggle.style.display = "none"
                }
            });

            function togglenavbar() {
                navbar_container.style.left = "0";
            }
        </script>
    </body>

    </html>
<?php
    } else {
        header("Location: /onboarding/login.php");
        exit();
    }
?>