<?php
    session_start();

    if (isset($_SESSION['user'])) {
        // Check if there is something in the query string
        if (!empty($_SERVER['QUERY_STRING'])) {
            // Generate JavaScript to wait for 10 seconds and then clear the query string
            echo '<script>';
            echo 'setTimeout(function() {';
            echo '    window.history.replaceState({}, document.title, "' . $_SERVER['PHP_SELF'] . '");';
            echo '}, 10000);'; // 10000 milliseconds = 10 seconds
            echo '</script>';
        }
        
        if(!empty($_SESSION['users'][$_SESSION['user']['username']]['noutes'])) {
            $noutes = $_SESSION['users'][$_SESSION['user']['username']]['noutes'];
        }
?>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" href="/user/user.css" />
        
        <title>Noutes | Home</title>
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
                <form method="post" action="handle_postnoute.php">
                    <div class="post_container">
                        <div class="post_wrapper" id="post_wrapper">
                            <div class="minimize_button" id="minimize_button" onclick="minimize(this)"><i class="fas fa-caret-down"></i></div>
                            <h3 class="font_aquire">Create a Noute</h3>
                            <hr />
                            <div class="postnoute_body">
                                <?php if (isset($_GET['error'])) { ?>    
                                    <div class="form_error"><?php echo $_GET['error']; ?></div>
                                <?php } ?>
                                <?php if (isset($_GET['success'])) { ?>
                                    <div class="form_success"><?php echo $_GET['success']; ?></div>
                                <?php } ?>
                                <input class="postnoute_field postnoute_title" name="title" placeholder="Noute title..."/>
                                <textarea class="postnoute_field postnoute_noute" name="noute" placeholder="Here is where your Noute goes..."></textarea>
                                <input class="postnoute_field postnoute_image" name="image" placeholder="Url of an image to go with your noute..."/>
                                <div class="buttons_container">
                                    <button type="submit" name="submit">Post Noute</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="noutes_container">
                    <?php
                        if(!empty($noutes)) {
                            for ($i = count($noutes) - 1; $i >= 0; $i--) {
                                $noute_id = $i;
                                $noute_title = $noutes[$i]['title'];
                                $noute_noute = $noutes[$i]['noute'];
                                $noute_image = $noutes[$i]['image'];
                                include '../components/noute_container.php';
                            }
                        }
                    ?>
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
            
            function minimize(element) {
                const minimize_button = document.getElementById('minimize_button');
                const post_wrapper = document.getElementById('post_wrapper');
                if(minimize_button.innerHTML === `<i class="fas fa-caret-down"></i>`) {
                    minimize_button.innerHTML = `<i class="fas fa-caret-up"></i>`;
                    post_wrapper.style.height = '3.5vw';
                } else {
                    minimize_button.innerHTML = `<i class="fas fa-caret-down"></i>`;
                    post_wrapper.style.height = 'auto';
                }
            }

            function jumptop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            function togglenavbar() {
                navbar_container.style.left = "0";
            }

            const images = document.querySelectorAll('.noute_images');
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