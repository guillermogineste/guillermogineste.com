<?php
// current_data.json contains each projects information
// It's fields $Name, $name and $description are available for each page
// Those variables are defined in the header.php file
$dataArray = json_decode(file_get_contents(__DIR__ . '/current_data.json'), true);
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/therefore/");
?>

<?php include(ROOT_PATH . "inc/header.php");?>
    <!-- NAVIGATION -->
    <?php include(ROOT_PATH . "inc/navigation.php"); ?>
    <!-- END NAVIGATION -->

    <!-- ASIDE -->
    <?php include(ROOT_PATH . "inc/aside.php"); ?>
    <!-- END ASIDE -->

    <!-- OVERLAY -->
    <div class="overlay"></div>
    <!-- END OVERLAY -->

    <!-- CONTENT -->
    <?php include(__DIR__ . "/content.php"); ?>
    <!-- END CONTENT -->
<?php include(ROOT_PATH . "inc/footer.php"); ?>
