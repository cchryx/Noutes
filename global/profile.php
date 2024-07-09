<?php
    session_start();

    if (isset($_SESSION['user'])) {
        if(isset($_GET['user'])) {
            $user_query = $_GET['user'];
            
            if(!isset($_SESSION['users'][$user_query])) {
                $user_data = $_SESSION['user'];
            } else {
                $user_data = $_SESSION['users'][$user_query];
            }
            
        }

        if(!isset($user_data)) {
            $user_data = $_SESSION['user'];
        } 

?>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" href="/global/profile.css" />

        <title>Noutes | Profile</title>
    </head>

    <body>
        <div class="lightbox_container" id="lightbox_container">
            <div class="close_container" onclick="unlightbox_image()">
                <i class="fas fa-times"></i>
            </div>
            <img class="lightbox_image" id="lightbox_image">
        </div>
        <?php include '../components/user_navbar.php' ?>
        <div class="navbar_toggle" id="navbar_toggle" onclick="togglenavbar()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="body_container">
            <div class="body_wrapper">
                <div class="profile_container">
                    <div class="profile_wrapper">
                        <div class="profile_left">
                            <img src="https://static.vecteezy.com/system/resources/previews/020/765/399/non_2x/default-profile-account-unknown-icon-black-silhouette-free-vector.jpg" class="profile_picture"/>
                        </div>
                        <div class="profile_right">
                            <p class="profile_username"><?php echo $user_data['username']; ?></p>
                            <p class="profile_fullname"><?php echo $user_data['fullname']; ?></p>
                            <ul>
                                <li>
                                    <?php 
                                        if(!empty($user_data['noutes'])) {
                                            echo count($user_data['noutes']);
                                        } else {
                                            echo 0;
                                        }
                                    ?> 
                                    Noutes
                                </li>
                                <li>0 Followers</li>
                                <li>0 Following</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="jumptop_container" onclick="jumptop()">
            <i class="fas fa-chevron-up"></i>
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

            function jumptop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function togglenavbar() {
                navbar_container.style.left = "0";
            }

            const images = document.querySelectorAll('.images');
            images.forEach(function(image) {
                image.addEventListener('click', function() {
                    lightbox_image(image.src);
                });
                image.addEventListener('error', function() {
                    image.style.display = 'none';
                });
            });

            function lightbox_image(image_src) {
                const lightbox_container = document.getElementById('lightbox_container');
                const lightbox_image = document.getElementById('lightbox_image');
                lightbox_container.style.display = 'flex';
                lightbox_image.src = image_src;
            }

            function unlightbox_image() {
                const lightbox_container = document.getElementById('lightbox_container');
                const lightbox_image = document.getElementById('lightbox_image');
                lightbox_container.style.display = 'none';
                lightbox_image.src = "";
            }

            // Initialize the Intersection Observer for lazy loading
            const lazyImages = document.querySelectorAll('.lazy');

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        console.log(img.dataset.src)
                        img.src = img.dataset.src; // Load the image
                        img.classList.remove('lazy'); // Remove the lazy class
                        observer.unobserve(img); // Unobserve the image
                    }
                });
            });

            lazyImages.forEach(image => {
                observer.observe(image);
            });
        </script>
    </body>

    </html>
<?php
    } else {
        header("Location: /onboarding/login.php");
        exit();
    }
?>