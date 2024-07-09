<?php
    session_start();
    include './PRODUCTS_LIST.php';

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
        if(!isset($_GET['error'])) {
            if(!isset($_GET['id']) || !isset($PRODUCTS_LIST[$_GET['id']])) {
                header("Location: /shop/product_display.php?error=Invalid product identification.");
            } else {
                $productID = $_GET['id'];
                $productDATA = $PRODUCTS_LIST[$productID];
            }   
        } 
?>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" href="/shop/shop.css" />

        <title>Noutes | Shop</title>
    </head>

    <body>
        <?php if (isset($_GET['editsetting'])) { ?>    
            <div class="lightbox_container" id="lightbox_container" style="display: flex;">
            </div>
        <?php } ?>
        <?php include '../components/user_navbar.php' ?>
        <div class="navbar_toggle" id="navbar_toggle" onclick="togglenavbar()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="body_container">
            <div class="header_container">
                <div class="header_wrapper">
                    <div class="header-links_container">
                        <ul class="header-links">
                            <li class="header-link_container">
                                <a href="/shop/products.php">
                                    <p>Products</p>
                                </a>
                            </li>
                            <li class="header-link_container">
                                <a href="/shop/cart.php">
                                    <p>Cart</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="body_wrapper">
                <?php if (isset($_GET['error'])) { ?>    
                    <div class="form_error"><?php echo $_GET['error']; ?></div>
                <?php } ?>
                <?php if (isset($_GET['success'])) { ?>
                    <div class="form_success"><?php echo $_GET['success']; ?></div>
                <?php } ?>
                <div class="products_container cart">
                    <?php 
                        if(isset($productDATA)) {
                            echo '<div class="product_container info">';
                            echo '<div class="product_container-top info">';
                            echo '<h3>' . $productDATA['name'] . '</h3>';
                            echo '<img class="product_image lazy" data-src="/shop/product_images/' . $productID . '.jpg" src="/assets/icons/loading.gif" />';
                            echo '<p>Price: $' . number_format($productDATA['price'], 2, '.', ',') . '</p>';
                            echo '<p>' . nl2br($productDATA['description']) . '</p>';
                            echo '</div>';
                            echo '<div class="product_container-bottom info">';
                            echo '<a href="cart_add.php?id=' . ($productID) . '">Add to Cart</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
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