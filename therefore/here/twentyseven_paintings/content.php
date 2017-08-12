<div class="preloader">
    <div class="status">
        <p>Loading 351 images,<br>please be patient.</p>
        <p class="loading"><span>&#149;</span><span>&#149;</span><span>&#149;</span></p>
    </div>
</div>
<div class="drag-to-move">
    <img class="drag-to-move__icon" src="/therefore/img/hand_icon_all@2x.png" width="43" height="43" alt="Drag to move in any direction" />
    <span class="drag-to-move__text">Drag to move</span>
</div>
<?php $location = "/therefore/here/" . $name . "/images"; ?>
<div class="content">
    <div id="scroller">
        <?php
        $letters = array("a", "b", "c", "d", "c", "d", "e", "f", "g", "h", "i",
            "j", "k", "l", "m", "n", "ni", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z");
        $numberOfLetters = 27;
        $numberOfImages = 12;
        for ($i = 0; $i <= count($letters)-1; $i++) {
            echo "<section class=\"letter\">";
            $currentLetter = $letters[$i];
            echo "<img src=\"{$location}/twenty-seven-paintings-{$currentLetter}.jpg\" height=\"500\" width=\"500\">";
            for ($j = 1; $j <= $numberOfImages ; $j++) {
                $position = str_pad($j, 2, '0', STR_PAD_LEFT);
                echo "<img src=\"{$location}/twenty-seven-paintings-{$currentLetter}{$position}.jpg\" height=\"500\" width=\"500\">";
            }
            echo "</section>";
        }
        ?>
    </div>
</div>
