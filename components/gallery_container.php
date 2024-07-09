<?php
    if (empty($_SESSION)) {
        session_start();
    }

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
?>
    <link rel="stylesheet" href="/components/gallery_container.css" />
    
    <div class="gallery_container">
        <div class="gallery_wrapper">
            <?php
                $directory = '../data/gallery_images';
        
                $images = scandir($directory);
                $imageExtensions = array('jpg', 'jpeg', 'png', 'gif');
        
                foreach ($images as $image) {
                    $extension = pathinfo($image, PATHINFO_EXTENSION);
        
                    if (in_array(strtolower($extension), $imageExtensions)) {
                        echo '<img data-src="' . $directory . '/' . $image . '" src="/assets/icons/loading.gif" alt="' . $image . '" onclick="lightbox_image()" class="gallery_image lazy" >';
                    }
                }
            ?>
        </div>
    </div>
    
    <script>
        const images = document.querySelectorAll('.gallery_image');
        images.forEach(function(image) {
            image.addEventListener('error', function() {
                // Image failed to load, hide it
                image.style.display = 'none';
            });
        });

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
<?php
    } else {
        header("Location: /onboarding/login.php");
        exit();
    }
?>
