<?php
    session_start();

    if (isset($_SESSION['user'])) {
?>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" href="/user/user.css" />
        
        <title>Noutes | Gallery</title>
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
                <?php include '../components/gallery_container.php' ?>
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

            // lightbox stuff
            images.forEach(function(image) {
                image.addEventListener('click', function() {
                    lightbox_image(image.src);
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
            
        </script>
    </body>

    </html>
<?php
    } else {
        header("Location: /onboarding/login.php");
        exit();
    }
?>