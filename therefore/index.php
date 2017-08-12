<?php
// current_data.json contains each projects information
// It's fields $Name, $name and $description are available for each page
// Those variables are defined in the header.php file
$dataArray = json_decode(file_get_contents(__DIR__ . '/current_data.json'), true);
?>

<?php include(__DIR__ . "/inc/header.php");?>
    <!-- NAVIGATION -->
    <?php include(__DIR__ . "/inc/navigation.php"); ?>
    <!-- END NAVIGATION -->

    <!-- ASIDE -->
    <?php include(__DIR__ . "/inc/aside.php"); ?>
    <!-- END ASIDE -->

    <!-- OVERLAY -->
    <div class="overlay"></div>
    <!-- END OVERLAY -->
<?php include(__DIR__ . "/inc/footer.php"); ?>
