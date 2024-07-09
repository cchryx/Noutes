<?php
    if (empty($_SESSION)) {
        session_start();
    }

    $currentURL = $_SERVER['REQUEST_URI'];

    if (isset($_SESSION['user'])) {
?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="/components/user_navbar.css" />
    
    <div class="navbar_container" id="navbar_container">
        <div class="navbar_wrapper">
            <div class="navbar-top_container" id="navbar-top_container">
                <h1 class="navbar-logo font_aquire">Noutes</h1>
            </div>
            <div class="navbar-middle_container">
                <div class="navbar-profile_container">
                    <a href="/global/profile.php?user=<?php echo $_SESSION['user']['username']; ?>" class="<?php echo (strpos($currentURL, '/global/profile.php') === 0) ? 'navbar-link_active' : ''; ?>">
                        <div class="navbar-profile_left">
                            <img src="https://static.vecteezy.com/system/resources/previews/020/765/399/non_2x/default-profile-account-unknown-icon-black-silhouette-free-vector.jpg" class="navbar-profile_profilepicture"/>
                        </div>
                        <div class="navbar-profile_right">
                            <p class="navbar-profile_fullname"><?php echo $_SESSION['user']['fullname']; ?></p>
                            <p class="navbar-profile_username">@<?php echo $_SESSION['user']['username']; ?></p>
                        </div>
                    </a>
                </div>
                <div class="navbar-links_container">
                    <ul class="navbar-links">
                        <li class="navbar-link_container">
                            <a href="/user/home.php" class="<?php echo (strpos($currentURL, '/user/home.php') === 0) ? 'navbar-link_active' : ''; ?>">
                                <i class="fas fa-sticky-note"></i>
                                <p>My Noutes</p>
                            </a>
                        </li>
                        <li class="navbar-link_container">
                            <a href="/user/gallery.php" class="<?php echo (strpos($currentURL, '/user/gallery.php') === 0) ? 'navbar-link_active' : ''; ?>">
                                <i class="fas fa-images"></i>
                                <p>Gallery</p>
                            </a>
                        </li>
                        <li class="navbar-link_container">
                            <a href="/shop/products.php" class="<?php echo (strpos($currentURL, '/shop/') === 0) ? 'navbar-link_active' : ''; ?>">
                                <i class="fas fa-shopping-bag"></i>
                                <p>Car Shop</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="navbar_divider"/>
            <div class="navbar-bottom_container">
                <div class="navbar-links_container">
                    <ul class="navbar-links">
                        <li class="navbar-link_container">
                            <a href="/user/settings.php" class="<?php echo (strpos($currentURL, '/user/settings.php') === 0) ? 'navbar-link_active' : ''; ?>">
                                <i class="fas fa-cog"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                        <li class="navbar-link_container a_logout"">
                            <a href="/onboarding/logout.php"><i class="fas fa-sign-out-alt"></i><p>Logout</p></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        const navbar_container = document.getElementById("navbar_container");
        const navbartop_container = document.getElementById("navbar-top_container");
        
        if (window.innerWidth <= 768) {
            navbartop_container.innerHTML = `
                <h1 class="navbar-logo font_aquire">Noutes</h1>
                <div class="navbar_untoggle" onclick="untogglenavbar()"><i class="fas fa-bars"></i></div>
            `
            navbar_container.style.left = "-98vw"
        }
        window.addEventListener('resize', function(event) {
            if (window.innerWidth <= 768) {
                navbartop_container.innerHTML = `
                    <h1 class="navbar-logo font_aquire">Noutes</h1>
                    <div class="navbar_untoggle" onclick="untogglenavbar()"><i class="fas fa-bars"></i></div>
                `
                navbar_container.style.left = "-98vw"
            } else {
                navbartop_container.innerHTML = `
                    <h1 class="navbar-logo font_aquire">Noutes</h1>
                `
                navbar_container.style.left = "auto"
            }
        });

        function untogglenavbar() {
            navbar_container.style.left = "-98vw";
        }
    </script>
<?php
    } else {
        header("Location: /onboarding/login.php");
        exit();
    }
?>