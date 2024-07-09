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
    <?php include './PRODUCTS_LIST.php'; ?>
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
                                <a href="" class="header-link_active">
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
                <?php
                    if(!empty($_SESSION['user']['cart'])) {
                        echo '<p style="font-size: 20px">Cart (' . count($_SESSION['user']['cart']) . ')</p>';
                    } 
                ?>
                <div class="products_container cart">
                    <?php 
                        $i = 0;

                        if(!empty($_SESSION['user']['cart'])) {
                            $total_cost = 0;
                            while ($i < count($_SESSION['user']['cart'])) {
                                $cart_itemID = $_SESSION['user']['cart'][$i];
                                echo '<div class="product_container cart">';
                                echo '<div class="product_container-left">';
                                echo '<img class="lazy" data-src="/shop/product_images/' . $cart_itemID . '.jpg" src="/assets/icons/loading.gif" />';
                                echo '</div>';
                                echo '<div class="product_container-middle">';
                                echo '<h3>' . $PRODUCTS_LIST[$cart_itemID]['name'] . '</h3>';
                                echo '<p>Price: $' . number_format($PRODUCTS_LIST[$cart_itemID]['price'], 2, '.', ',') . '</p>';
                                echo '</div>';
                                echo '<div class="product_container-right cart">';
                                echo '<a href="/shop/cart_remove.php?index=' . $i . '"><i class="fas fa-minus"></i></a>';
                                echo '</div>';
                                echo '</div>';

                                $total_cost += $PRODUCTS_LIST[$cart_itemID]['price'];
                                $i++;
                            }
                            echo '<p>Sub Total: $' . number_format($total_cost, 2, '.', ',') . '</p>';
                            echo '<p>Tax: $' . number_format($total_cost * 0.13, 2, '.', ',') . ' (13%)</p>';
                            echo '<p>Total: $' . number_format($total_cost * 1.13, 2, '.', ',') . '</p>';
                            echo '<div class="cart_buttons">';
                            echo '<a href="cart_clear.php" class="cart_button">Clear Cart</a>';
                            echo '</div>';
                        } else {
                            echo '<div class="form_information">No items in cart currently.</div>'; 
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