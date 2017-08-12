    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script>


    <?php
        // define("PHP_ROOT", "/therefore/");

        echo "<script src=\"". PHP_ROOT ."js/plugins.js\"></script>";
        echo "<script src=\"". PHP_ROOT ."js/main.js\"></script>";
        echo "<script src=\"". PHP_ROOT ."js/iscroll.js\"></script>";

        if ($name == "index") {

        } else if ($name == "newsletter") {
            echo "<script src=\"". PHP_ROOT ."{$name}/js/{$name}_js.js\"></script>";
        } else {
            if ($parent == "") {
                echo "<script src=\"". PHP_ROOT ."here/{$name}/js/{$name}_js.js\"></script>";
            } else {
                echo "<script src=\"". PHP_ROOT ."here/{$parent}/{$name}/js/{$name}_js.js\"></script>";
            }
        }
    ?>

    <script>
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='https://www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','UA-31309357-1','auto');ga('send','pageview');
        </script>
    </body>
</html>
