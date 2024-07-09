<?php
    if (empty($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['user'])) {
?>
    <link rel="stylesheet" href="/components/noute_container.css" />
    
    <div class="noute_container" id="<?php echo $noute_id; ?>">
        <div class="noute_wrapper">
            <div class="noute_top">
                <div class="noute_top_left">
                    <h3 class="noute_title"><?php echo $noute_title; ?></h3>
                </div>
                <div class="noute_top_right">
                    <div><i class="fas fa-ellipsis-v"></i></div>
                </div>
            </div>
            <p class="noute_noute"><?php echo $noute_noute; ?></p>
            <?php
                if (!empty($noute_image)) {
                    echo '<img data-src="' . $noute_image . '" src="/assets/icons/loading.gif" class="noute_images lazy" />';
                } 
            ?>
        </div>
    </div>
<?php
    } else {
        header("Location: /onboarding/login.php");
        exit();
    }
?>