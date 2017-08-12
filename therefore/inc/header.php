<?php
    define("PHP_ROOT", "/therefore/");

    $Name = $dataArray["Name"];
    $name = $dataArray["name"];
    $shortDescription = $dataArray["shortDescription"];
    $description = $dataArray["description"];
    $parent = $dataArray["parent"];
    // $currentURL = PHP_ROOT . $name ;
    $currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>

<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta property="og:url"                content="<?php echo $currentURL; ?>" />
        <meta property="og:type"               content="website" />
        <meta property="og:title"              content="<?php echo $Name; ?>" />
        <meta property="og:description"        content="<?php echo $shortDescription; ?>" />
        <?php
        if ($name == "index") {
            echo "<meta property=\"og:image\" content=\"" . PHP_ROOT . "fb_" . $name . ".jpg\">";
        } else {
            if ($parent == "") {
                echo "<meta property=\"og:image\" content=\"" . PHP_ROOT . "here/{$name}/" . "fb_" . $name . ".jpg\">";
            } else {
                echo "<meta property=\"og:image\" content=\"" . PHP_ROOT . "here/{$parent}/{$name}/" . "fb_" . $name . ".jpg\">";
            }
        }
        ?>

        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <?php
            if ($name == "index") {
                echo "<title>Guillermo Gineste</title>";
            } else {
                echo "<title>Guillermo Gineste &minus; {$Name}</title>";
            }
        ?>
        <meta name="description" content="<?php echo $shortDescription; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="/therefore/favicon.png">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Source+Serif+Pro' rel='stylesheet' type='text/css'>

        <?php
          echo "<link rel=\"stylesheet\" href=\"". PHP_ROOT ."css/main.css\">";
          echo "<script src=\"". PHP_ROOT ."js/vendor/modernizr-2.8.3.min.js\"></script>";

            // if ($name == "index") {
            //     // INDEX
            //     echo "<link rel=\"stylesheet\" href=\"". PHP_ROOT ."css/main.css\">";
            //     echo "<script src=\"". PHP_ROOT ."js/vendor/modernizr-2.8.3.min.js\"></script>";
            // } else if ($name == "newsletter") {
            //     // NEWSLETTER
            //     echo "<link rel=\"stylesheet\" href=\"". PHP_ROOT ."css/main.css\">";
            //     echo "<link rel=\"stylesheet\" href=\"". PHP_ROOT ."{$name}/css/{$name}_style.css\">";
            //     echo "<script src=\"". PHP_ROOT ."js/vendor/modernizr-2.8.3.min.js\"></script>";
            // } else {
            //     // SINGLE PROJECT
            //     if ($parent == "") {
            //         echo "<link rel=\"stylesheet\" href=\"". PHP_ROOT ."css/main.css\">";
            //         echo "<link rel=\"stylesheet\" href=\"". PHP_ROOT ."here/{$name}/css/{$name}_style.css\">";
            //         echo "<script src=\"". PHP_ROOT ."js/vendor/modernizr-2.8.3.min.js\"></script>";
            //     } else {
            //         echo "<link rel=\"stylesheet\" href=\"". PHP_ROOT ."css/main.css\">";
            //         echo "<link rel=\"stylesheet\" href=\"". PHP_ROOT ."here/{$parent}/{$name}/css/{$name}_style.css\">";
            //         echo "<script src=\"". PHP_ROOT ."js/vendor/modernizr-2.8.3.min.js\"></script>";
            //     }
            // }
        ?>

    </head>
    <body id="<?php echo $name ?>">
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
