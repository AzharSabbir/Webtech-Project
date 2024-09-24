<header>
    <?php
    // Dynamically set the tab name based on the page
    if (isset($page_title)) {
        echo $page_title;
    } else {
        echo "Dashboard"; // Default value
    }
    ?>
</header>
